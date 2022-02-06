<?php

namespace App\Entity\Site\Slider;

use App\Component\ModuleMetadata as ModuleMetadata;
use App\Repository\Site\Slider\ImageRepository;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\SortOrder;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[ModuleMetadata\Module(title: 'Слайдер картинок', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Map' => 20000000,
    'Additional' => 30000418
])]
#[Entity(repositoryClass: ImageRepository::class)]
#[Table(name: 'slider_image')]
class Image
{
    use Id, Name, Active, SortOrder, \App\Traits\EntityFields\Text, \App\Traits\EntityFields\Image;
}
