<?php

namespace App\Entity;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Repository\DesktopEntryRepository;
use App\Traits\EntityFields\EvalScript;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\SortOrder;
use App\Traits\EntityFields\Url;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'Desktop entry', tab_order: [
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
#[Entity(repositoryClass: DesktopEntryRepository::class)]
class DesktopEntry
{
    use Id, Name, Url, EvalScript, \App\Traits\EntityFields\Icon, SortOrder;
}
