<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site;


use App\Controller\ReferenceController;
use App\Entity\Site\Comment;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController
 * @package App\Controller\Site
 */
#[Route(path: '/comment', name: 'comment_')]
class CommentController extends ReferenceController
{
    /**
     * @var string
     */
    protected $entityClassName = Comment::class;
}
