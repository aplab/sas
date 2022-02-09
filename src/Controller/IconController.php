<?php namespace App\Controller;

use App\Component\DataTableRepresentation\DataTableRepresentation;
use App\Component\Helper\EntityControllerHelper;
use App\Entity\Icon;
use App\Service\FontawesomeIconManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/icon', name: 'icon_')]
class IconController extends ReferenceController
{
    protected string $entityClassName = Icon::class;
    protected FontawesomeIconManager $iconManager;

    public function __construct(EntityControllerHelper $adminControllerHelper, FontawesomeIconManager $iconManager)
    {
        parent::__construct($adminControllerHelper);
        $this->iconManager = $iconManager;
    }

    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function listItems(DataTableRepresentation $data_table_representation): Response
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

    #[Route(path: '/load-defaults', name: 'load_defaults', methods: ['POST'])]
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
