<?php

namespace App\Entity\GalleryBuilder;

use App\Component\ModuleMetadata as ModuleMetadata;
use App\Repository\GalleryBuilder\ImageRepository;
use App\Traits\EntityFields\Alt;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\SortOrder;
use App\Traits\EntityFields\Source;
use App\Traits\EntityFields\SourceUrl;
use Doctrine\ORM\Mapping\Entity;

#[ModuleMetadata\Module(title: 'Gallery builder item')]
#[Entity(repositoryClass: ImageRepository::class)]
class Image
{
    use Id, Name, \App\Traits\EntityFields\Image, SortOrder, Source, SourceUrl, Alt;
}
