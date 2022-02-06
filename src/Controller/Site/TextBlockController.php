<?php namespace App\Controller\Site;

use App\Controller\ReferenceController;
use App\Entity\Site\TextBlock;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/text-block', name: 'text_block_')]
class TextBlockController extends ReferenceController
{
    protected string $entityClassName = TextBlock::class;
}
