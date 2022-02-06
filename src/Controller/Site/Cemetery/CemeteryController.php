<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site\Cemetery;


use App\Controller\ReferenceController;
use App\Entity\Site\Cemetery\Cemetery;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\Site\Catalog\Flowers
 */
#[Route(path: '/cemetery', name: 'cemetery_')]
class CemeteryController extends ReferenceController
{
    protected string $entityClassName = Cemetery::class;
}
