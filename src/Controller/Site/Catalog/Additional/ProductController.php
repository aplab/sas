<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site\Catalog\Additional;


use App\Controller\ReferenceController;
use App\Entity\Site\Catalog\Additional\Product;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\Site\Catalog\Additional
 */
#[Route(path: '/additional', name: 'additional_')]
class ProductController extends ReferenceController
{
    /**
     * @var string
     */
    protected $entityClassName = Product::class;
}
