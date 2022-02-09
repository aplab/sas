<?php namespace App\Controller;

use App\Component\DataTableRepresentation\DataTableRepresentation;
use App\Entity\UserFiles\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/user-files', name: 'user_files_')]
class UserFilesController extends ReferenceController
{
    protected string $entityClassName = File::class;

    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function listItems(DataTableRepresentation $data_table_representation): Response
    {
        $helper = $this->adminControllerHelper;
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addUrl('New item', $helper->getModulePath('add'), 'fas fa-plus text-success');
        $toolbar->addHandler('Delete selected', 'AplDataTable.getInstance().del();', 'fas fa-times text-danger');
        $toolbar->addHandler('Batch', 'AplDataTable.getInstance().batchAddFilesPlugin()', 'fas fa-th');
        $data_table = $data_table_representation->getDataTable($this->getEntityClassName());
        $pager = $data_table->getPager();
        return $this->render('data-table/data-table.html.twig', get_defined_vars());
    }
}
