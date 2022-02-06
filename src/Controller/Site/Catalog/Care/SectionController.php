<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site\Catalog\Care;


use App\Controller\ReferenceController;
use App\Entity\Site\Catalog\Care\Section;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\Site\Catalog\Care
 */
#[Route(path: '/care-section', name: 'care_section_')]
class SectionController extends ReferenceController
{
    /**
     * @var string
     */
    protected $entityClassName = Section::class;
}
