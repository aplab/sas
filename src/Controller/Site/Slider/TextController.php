<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site\Slider;


use App\Controller\ReferenceController;
use App\Entity\Site\Slider\Text;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\Site\Slider\Text
 */
#[Route(path: '/slider-text', name: 'slider_text_')]
class TextController extends ReferenceController
{
    protected string $entityClassName = Text::class;
}
