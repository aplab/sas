<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.08.2018
 * Time: 17:56
 */

namespace App\Controller\Site\Catalog\Flowers;


use App\Controller\ReferenceController;
use App\Entity\Site\Catalog\Flowers\Product;
use App\Service\ThumbnailGenerator;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\Site\Catalog\Flowers
 */
#[Route(path: '/flowers', name: 'flowers_')]
class ProductController extends ReferenceController
{
    protected string $entityClassName = Product::class;

    protected ThumbnailGenerator $thumbnailGenerator;

    public function setThumbnailGenerator(ThumbnailGenerator $t): static
    {
        $this->thumbnailGenerator = $t;
        /** @noinspection PhpUndefinedMethodInspection */
        ($this->entityClassName)::setThumbnailGenerator($this->thumbnailGenerator);
        return $this;
    }
}
