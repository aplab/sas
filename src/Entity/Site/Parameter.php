<?php

namespace App\Entity\Site;

use App\Component\ModuleMetadata\Module;
use App\Repository\Site\ParameterRepository;
use App\Traits\EntityFields\Code;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Image;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\Text;
use App\Traits\EntityFields\Textarea;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;

#[Module(title: 'Parameter', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: ParameterRepository::class)]
#[Index(columns: ['code'], name: 'code')]
class Parameter
{
    use Id, Code, Text, Image, Textarea, Name;
}
