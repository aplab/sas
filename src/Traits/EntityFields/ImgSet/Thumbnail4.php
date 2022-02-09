<?php namespace App\Traits\EntityFields\ImgSet;

use App\Component\ModuleMetadata\Property;
use Doctrine\ORM\Mapping\Column;

trait Thumbnail4
{
    #[Property(title: 'Thumbnail 4')]
    #[Column(type: 'string')]
    protected string $thumbnail4 = '';

    public function getThumbnail4(): string
    {
        return $this->thumbnail4;
    }

    public function setThumbnail4(string $thumbnail4): static
    {
        $this->thumbnail4 = $thumbnail4;
        return $this;
    }
}
