<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Component\DataTableRepresentation\DataTableOrderMod;
use App\Component\DataTableRepresentation\DataTableRepresentation;
use App\Component\Toolbar\Exception;
use App\Entity\GalleryBuilder\Image;
use App\Helper\SourceLink\OytoySourceLink;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 */
#[Route(path: '/gallery-builder', name: 'gallery_builder_')]
class GalleryBuilderController extends ReferenceController
{
    /**
     * @var string
     */
    protected $entityClassName = Image::class;
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
        $helper  = $this->adminControllerHelper;
        $toolbar = $this->adminControllerHelper->getToolbar();
        $toolbar->addUrl('New item', $helper->getModulePath('add'), 'fas fa-plus text-success');
        $toolbar->addHandler('Delete selected', 'AplDataTable.getInstance().del();', 'fas fa-times text-danger');
        $toolbar->addHandler('Batch', 'AplDataTable.getInstance().galleryBuilderPlugin()', 'fas fa-th');
        $ti = $toolbar->addUrl('Build', $helper->getModulePath('gallery'), 'fas fa-images text-warning');
        $toolbar->addHandler('Alt all', 'AplDataTable.getInstance().galleryBuilderMassFillAltPlugin()', 'fas fa-list-alt');
        $ti->setTarget('_blank');
        $data_table = $data_table_representation->getDataTable($this->getEntityClassName(), DataTableOrderMod::class);
        $pager      = $data_table->getPager();
        return $this->render('data-table/data-table.html.twig', get_defined_vars());
    }
    /**
     * @return Response
     */
    #[Route(path: '/gallery', name: 'gallery', methods: ['GET'])]
    public function gallery()
    {
        $repo  = $this->getDoctrine()->getRepository(Image::class);
        $items = $repo->findBy([], ['sortOrder' => 'ASC', 'id' => 'ASC'],);
        foreach ($items as $item) {
            $source_link = new OytoySourceLink;
            $source_link->setLabel($item->getSource())->setUrl($item->getSourceUrl());
            $item->sourceLink = $source_link;
        }
        unset($repo);
        return $this->render('gallery-builder.html.twig', get_defined_vars());
    }
    /**
     * @return Response
     */
    #[Route(path: '/alt-all', name: 'alt-all', methods: ['POST'])]
    public function altAll()
    {
        if (!isset($_POST['alt'])) {
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
        }
        $alt = $_POST['alt'];
        if (!is_scalar($alt)) {
            return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
        }
        $alt = mb_substr($alt, 0, 16384);
        $repo  = $this->getDoctrine()->getRepository(Image::class);
        $em = $this->getDoctrine()->getManager();
        $items = $repo->findAll();
        foreach ($items as $item) {
            $item->setAlt($alt);
            $em->persist($item);
        }
        $em->flush();
        return $this->redirectToRoute($this->getRouteAnnotation()->getName() . 'list');
    }
}
