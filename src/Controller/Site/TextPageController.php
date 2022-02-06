<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site;


use App\Controller\ReferenceController;
use App\Entity\Site\TextPage;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewsController
 * @package App\Controller\Site
 */
#[Route(path: '/text-page', name: 'text_page_')]
class TextPageController extends ReferenceController
{
    /**
     * @var string
     */
    protected $entityClassName = TextPage::class;
}
