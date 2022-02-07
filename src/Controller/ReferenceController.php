<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Component\DataTableRepresentation\DataTableRepresentation;
use App\Component\InstanceEditor\InstanceEditorManager;
use App\Component\Toolbar\Exception;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use RuntimeException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Class ReferenceAdminController
 * @package App\Controller
 */
abstract class ReferenceController extends EntityController
{
    /**
     * @param DataTableRepresentation $data_table_representation
     * @return Response
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws Exception
     */
    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function listItems(DataTableRepresentation $data_table_representation)
    {
        $helper  = $this->adminControllerHelper;
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addUrl('New item', $helper->getModulePath('add'), 'fas fa-plus text-success');
        $toolbar->addHandler('Delete selected', 'AplDataTable.getInstance().del();', 'fas fa-times text-danger');
        $toolbar->addHandler('Clone selected', 'AplDataTable.getInstance().duplicate();', 'far fa-clone text-warning');
        $data_table = $data_table_representation->getDataTable($this->getEntityClassName());
        $pager      = $data_table->getPager();
        return $this->render('data-table/data-table.html.twig', get_defined_vars());
    }

    /**
     * @param DataTableRepresentation $data_table_representation
     * @return RedirectResponse
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    #[Route(path: '/', name: 'list_param', methods: ['POST'])]
    public function setListParam(DataTableRepresentation $data_table_representation)
    {
        if (isset($_POST['itemsPerPage']) && isset($_POST['pageNumber'])) {
            $data_table = $data_table_representation->getDataTable($this->getEntityClassName());
            $pager      = $data_table->getPager();
            $pager->setItemsPerPage($_POST['itemsPerPage']);
            $pager->setCurrentPage($_POST['pageNumber']);
        }
        return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
    }

    #[Route(path: '/del', name: 'drop', methods: ['POST'])]
    public function dropItem()
    {
        $class          = $this->getEntityClassName();
        $entity_manager = $this->getDoctrine()->getManager();
        $class_metadata = $entity_manager->getClassMetadata($class);
        $pk             = $class_metadata->getIdentifier();
        /**
         * @TODO composite key support
         */
        if (empty($pk)) {
            throw new RuntimeException('identifier not found');
        }
        if (sizeof($pk) > 1) {
            throw new RuntimeException('composite identifier not supported');
        }
        $key   = reset($pk);
        $ids   = $_POST[$key];
        $ids   = json_decode($ids);
        $items = $entity_manager->getRepository($class)->findBy([$key => $ids]);
        foreach ($items as $item) {
            $entity_manager->remove($item);
        }
        try {
            $entity_manager->flush();
        } catch (Throwable $exception) {
            $m = $exception->getMessage();
            if (preg_match('/delete.*?sqlstate.*?parent.*?constraint.*?foreign/is', $m)) {
                $text = 'Невозможно удалить выбранные объекты, пока на них ссылаются другие модули. Детали операции: ' . $m;
                $this->addFlash('error', $text);
            } else {
                $text = 'Невозможно удалить выбранные объекты. Детали операции: ' . $m;
                $this->addFlash('error', $text);
            }
        }
        return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
    }

    #[Route(path: '/duplicate', name: 'duplicate', methods: ['POST'])]
    public function duplicate()
    {
        $class          = $this->getEntityClassName();
        $entity_manager = $this->getDoctrine()->getManager();
        $class_metadata = $entity_manager->getClassMetadata($class);
        $pk             = $class_metadata->getIdentifier();
        /**
         * @TODO composite key support
         */
        if (empty($pk)) {
            throw new RuntimeException('identifier not found');
        }
        if (sizeof($pk) > 1) {
            throw new RuntimeException('composite identifier not supported');
        }
        $key   = reset($pk);
        $ids   = $_POST[$key];
        $ids   = json_decode($ids);
        $items = $entity_manager->getRepository($class)->findBy([$key => $ids]);
        try {
            foreach ($items as $item) {
                $copy = clone($item);
                $entity_manager->persist($copy);
            }
            $entity_manager->flush();
        } catch (Throwable $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
        }
        return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
    }

    /**
     * @param InstanceEditorManager $instanceEditorManager
     * @return Response
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    #[Route(path: '/add', name: 'add', methods: ['GET'])]
    public function addItem(InstanceEditorManager $instanceEditorManager)
    {
        $helper  = $this->adminControllerHelper;
        $helper->getHtmlTitle()->prependPart(__FUNCTION__);
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addHandler('Save', 'AplInstanceEditor.getInstance().save();', 'fas fa-save text-success');
        $toolbar->addHandler('Save and exit', 'AplInstanceEditor.getInstance().saveAndExit();',
                             'fas fa-save text-success');
        $toolbar->addUrl('Exit without saving', $helper->getModulePath(), 'fas fa-sign-out-alt text-danger flip-h');
        $entity_class_name = $this->getEntityClassName();
        $item              = new $entity_class_name;
        $instance_editor   = $instanceEditorManager->getInstanceEditor($item);
        $list_items_route_name = $this->getRouteAnnotation()->getName() . 'list';
        return $this->render('instance-editor/instance-editor.html.twig', get_defined_vars());
    }

    /**
     * @param InstanceEditorManager $instanceEditorManager
     * @param Request $request
     * @return RedirectResponse
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    #[Route(path: '/add', name: 'create', methods: ['POST'])]
    public function createItem(InstanceEditorManager $instanceEditorManager, Request $request)
    {
        $entity_class_name = $this->getEntityClassName();
        $item              = new $entity_class_name;
        $instance_editor   = $instanceEditorManager->getInstanceEditor($item);
        try {
            $instance_editor->handleRequest($request);
        } catch (Throwable $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'add');
        }
        if ($request->request->has('saveAndExit')) {
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
        }
        if ($item->getId()) {
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'edit', ['id' => $item->getId()]);
        }
    }

    /**
     * @param $id
     * @param InstanceEditorManager $instance_editor_manager
     * @return Response
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    #[Route(path: '/{id}', name: 'edit', methods: ['GET'])]
    public function editItem($id, InstanceEditorManager $instance_editor_manager)
    {
        $helper  = $this->adminControllerHelper;
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addHandler('Save', 'AplInstanceEditor.getInstance().save();', 'fas fa-save text-success');
        $toolbar->addHandler('Save and exit', 'AplInstanceEditor.getInstance().saveAndExit();',
                             'fas fa-save text-success');
        $toolbar->addUrl('Exit without saving', $helper->getModulePath(), 'fas fa-sign-out-alt text-danger flip-h');
        $entity_class_name = $this->getEntityClassName();
        $item              = $instance_editor_manager->getEntityManagerInterface()->find($entity_class_name, $id);
        if (!$item) {
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
        }
        if (method_exists($item, 'getId')) {
            $helper->getHtmlTitle()->prependPart($item->getId());
        }
        $instance_editor = $instance_editor_manager->getInstanceEditor($item);
        $list_items_route_name = $this->getRouteAnnotation()->getName() . 'list';
        return $this->render('instance-editor/instance-editor.html.twig', get_defined_vars());
    }

    /**
     * @param $id
     * @param InstanceEditorManager $instance_editor_manager
     * @param Request $request
     * @return RedirectResponse
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    #[Route(path: '/{id}', name: 'update', methods: ['POST'])]
    public function updateItem($id, InstanceEditorManager $instance_editor_manager, Request $request)
    {
        $entity_class_name = $this->getEntityClassName();
        $item              = $instance_editor_manager->getEntityManagerInterface()->find($entity_class_name, $id);
        if (!$item) {
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
        }
        $instance_editor = $instance_editor_manager->getInstanceEditor($item);
        try {
            $instance_editor->handleRequest($request);
        } catch (Throwable $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'edit', ['id' => $id]);
        }
        if ($request->request->has('saveAndExit')) {
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
        }
        return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'edit', ['id' => $id]);
    }
}
