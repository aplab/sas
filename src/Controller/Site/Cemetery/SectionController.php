<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site\Cemetery;


use App\Controller\ReferenceController;
use App\Entity\Site\Cemetery\Section;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\Site\Cemetery
 */
#[Route(path: '/cemetery-section', name: 'cemetery_section_')]
class SectionController extends ReferenceController
{
    protected string $entityClassName = Section::class;
}
