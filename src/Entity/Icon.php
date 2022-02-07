<?php

namespace App\Entity;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Repository\IconRepository;
use App\Traits\EntityFields\Code;
use App\Traits\EntityFields\IconStyleClass;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'Icon', description: 'Icon entity', tab_order: [
    TabDef::GENERAL => 1000,
    TabDef::TEXT => 2000,
    TabDef::SHORT => 2100,
    TabDef::FULL => 2200,
    TabDef::IMAGE => 1000000,
    TabDef::SEO => 10000000,
    TabDef::ADDITIONAL => 10000418,
    TabDef::SECURITY => 10000518,
    TabDef::MAP => 10000618,
])]
#[Entity(repositoryClass: IconRepository::class)]
class Icon
{
    use Id, Name, Code, IconStyleClass;
}
