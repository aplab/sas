<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site\Slider;


use App\Controller\ReferenceController;
use App\Entity\Site\Slider\Image;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\Site\Slider\Image
 */
#[Route(path: '/slider-image', name: 'slider_image_')]
class ImageController extends ReferenceController
{
    protected string $entityClassName = Image::class;
}
