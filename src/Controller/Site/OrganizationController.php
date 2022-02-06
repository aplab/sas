<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site;


use App\Controller\ReferenceController;
use App\Entity\Site\Organization;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewsController
 * @package App\Controller\Site
 */
#[Route(path: '/organization', name: 'organization_')]
class OrganizationController extends ReferenceController
{
    protected string $entityClassName = Organization::class;
}
