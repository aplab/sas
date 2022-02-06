<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Component\DataTableRepresentation\DataTableRepresentation;
use App\Component\DataTableRepresentation\DataTableRepresentationTreeMod;
use App\Component\DataTableRepresentation\DataTableTreeMod;
use App\Component\Toolbar\Exception;
use App\Entity\AdjacencyList\ListItem;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NamedTimestampableController
 * @package App\Controller
 */
#[Route(path: '/tree', name: 'tree_')]
class TreeController extends ReferenceController
{
    /**
     * @var string
     */
    protected $entityClassName = ListItem::class;
    /**
     * @param DataTableRepresentation $data_table_representation
     * @return Response
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function listItems(DataTableRepresentation $data_table_representation)
    {
        $helper = $this->adminControllerHelper;
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addUrl('New item', $helper->getModulePath('add'), 'fas fa-plus text-success');
        $toolbar->addHandler('Delete selected', 'AplDataTable.getInstance().del();', 'fas fa-times text-danger');
        $toolbar->addHandler('Clone selected', 'AplDataTable.getInstance().duplicate();', 'far fa-clone text-warning');
        $data_table = $data_table_representation->getDataTable($this->getEntityClassName(), DataTableTreeMod::class);
        $pager = $data_table->getPager();
        return $this->render('data-table/data-table.html.twig', get_defined_vars());
    }
}
