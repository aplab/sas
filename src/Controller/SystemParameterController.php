<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Component\DataTableRepresentation\DataTableRepresentation;
use App\Entity\SystemParameter;
use App\Repository\SystemParameterRepository;
use App\Resources\SystemParameterDefault;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/system-parameter', name: 'system_parameter_')]
class SystemParameterController extends ReferenceController
{
    protected string $entityClassName = SystemParameter::class;

    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function listItems(DataTableRepresentation $data_table_representation): Response
    {
        $helper = $this->adminControllerHelper;
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addUrl('New item', $helper->getModulePath('add'), 'fas fa-plus text-success');
        $toolbar->addHandler('Delete selected', 'AplDataTable.getInstance().del();', 'fas fa-times text-danger');
        $toolbar->addHandler('Clone selected', 'AplDataTable.getInstance().duplicate();', 'far fa-clone text-warning');
        $toolbar->addHandler('Factory reset', 'AplDataTable.getInstance().resetParametersPlugin(\'reset-parameters\');', 'fas fa-skull-crossbones text-danger');

        $data_table = $data_table_representation->getDataTable($this->getEntityClassName());
        $pager = $data_table->getPager();
        return $this->render('data-table/data-table.html.twig', get_defined_vars());
    }

    #[Route(path: '/reset-parameters', name: 'reset_parameters', methods: ['POST'])]
    public function resetParameters()
    {
        $class = $this->getEntityClassName();
        $entity_manager = $this->getDoctrine()->getManager();
        /*** @var SystemParameterRepository $repo */
        $repo = $entity_manager->getRepository($class);
        $defaults = SystemParameterDefault::get();
        $tokens = [];
        foreach ($defaults as $default) {
            $tokens[] = $default->getToken();
        }
        $items = $repo->findByToken(...$tokens);
        foreach ($items as $item) {
            $entity_manager->remove($item);
        }
        foreach ($defaults as $default) {
            $entity_manager->persist($default);
        }
        $entity_manager->flush();
        return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
    }
}
