<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Component\DataTableRepresentation\DataTableRepresentation;
use App\Component\Helper\EntityControllerHelper;
use App\Component\Toolbar\Exception;
use App\Entity\Icon;
use App\Entity\SystemParameter;
use App\Repository\SystemParameterRepository;
use App\Resources\SystemParameterDefault;
use App\Service\FontawesomeIconManager;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IconController
 * @package App\Controller
 * @Route("/icon", name="icon_")
 */
class IconController extends ReferenceController
{
    /**
     * @var string
     */
    protected string $entityClassName = Icon::class;
    protected FontawesomeIconManager $iconManager;

    public function __construct(EntityControllerHelper $adminControllerHelper, FontawesomeIconManager $iconManager)
    {
        parent::__construct($adminControllerHelper);
        $this->iconManager = $iconManager;
    }

    /**
     * @Route("/", name="list", methods="GET")
     * @param DataTableRepresentation $data_table_representation
     * @return Response
     * @throws Exception
     * @throws ReflectionException
     */
    public function listItems(DataTableRepresentation $data_table_representation)
    {
        $helper = $this->adminControllerHelper;
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addUrl('New item', $helper->getModulePath('add'), 'fas fa-plus text-success');
        $toolbar->addHandler('Delete selected', 'AplDataTable.getInstance().del();', 'fas fa-times text-danger');
        $toolbar->addHandler('Clone selected', 'AplDataTable.getInstance().duplicate();', 'far fa-clone text-warning');
        $toolbar->addHandler('Reset to defaults', 'AplDataTable.getInstance().resetParametersPlugin(\'load-defaults\');', 'fas fa-skull-crossbones text-danger');

        $data_table = $data_table_representation->getDataTable($this->getEntityClassName());
        $pager = $data_table->getPager();
        return $this->render('data-table/data-table.html.twig', get_defined_vars());
    }

    /**
     * @Route("/load-defaults", name="load_defaults", methods="POST")
     */
    public function loadDefaults()
    {
        $class = $this->getEntityClassName();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($class);
        $entities = $repo->findAll();
        foreach ($entities as $entity) {
            $em->remove($entity);
        }
        $data = $this->iconManager->buildData();
        foreach ($data as $k => $v) {
            $icon = new Icon;
            $icon->setName($v['name']);
            $icon->setCode($v['code']);
            $icon->setIconStyleClass($v['class']);
            $em->persist($icon);
        }
        $em->flush();
        return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
    }
}
