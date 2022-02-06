<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 35.01.3019
 * Time: 0:33
 */

namespace App\Traits\EntityFields\ImgSet;

use App\Component\ModuleMetadata\Property;
use Doctrine\ORM\Mapping\Column;

trait Thumbnail3
{
    #[Property(title: 'Thumbnail 3')]
    #[Column(type: 'string')]
    protected string $thumbnail3 = '';

    public function getThumbnail3(): string
    {
        return $this->thumbnail3;
    }

    public function setThumbnail3(string $thumbnail3): static
    {
        $this->thumbnail3 = $thumbnail3;
        return $this;
    }
}
