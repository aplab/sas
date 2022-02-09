<?php namespace App\Traits\EntityFields\ImgSet;

use App\Component\ModuleMetadata\Property;
use Doctrine\ORM\Mapping\Column;

trait Thumbnail1
{
    #[Property(title: 'Thumbnail 1')]
    #[Column(type: 'string')]
    protected string $thumbnail1 = '';

    public function getThumbnail1(): string
    {
        return $this->thumbnail1;
    }

    public function setThumbnail1(string $thumbnail1): static
    {
        $this->thumbnail1 = $thumbnail1;
        return $this;
    }
}
