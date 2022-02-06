<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site\Catalog\Flowers;


use App\Controller\ReferenceController;
use App\Entity\Site\Catalog\Flowers\Section;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\Site\Catalog\Flowers
 */
#[Route(path: '/flowers-section', name: 'flowers_section_')]
class SectionController extends ReferenceController
{
    /**
     * @var string
     */
    protected $entityClassName = Section::class;
}
