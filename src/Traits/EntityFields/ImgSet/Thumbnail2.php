<?php namespace App\Traits\EntityFields\ImgSet;

use App\Component\ModuleMetadata\Property;
use Doctrine\ORM\Mapping\Column;

trait Thumbnail2
{
    #[Property(title: 'Thumbnail 2')]
    #[Column(type: 'string')]
    protected string $thumbnail2 = '';

    public function getThumbnail2(): string
    {
        return $this->thumbnail2;
    }

    public function setThumbnail2(string $thumbnail2): static
    {
        $this->thumbnail2 = $thumbnail2;
        return $this;
    }
}
