<?php

namespace App\Entity\Site;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Repository\Site\CityRepository;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\IsDefault;
use App\Traits\EntityFields\LatitudeDecimal;
use App\Traits\EntityFields\LongitudeDecimal;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\NameEn;
use App\Traits\EntityFields\Okato;
use App\Traits\EntityFields\Subdomain;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'Город', tab_order: [
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
#[Entity(repositoryClass: CityRepository::class)]
class City
{
    use Id, Name, NameEn, LatitudeDecimal, LongitudeDecimal, Active, IsDefault, Okato, Subdomain;
}
