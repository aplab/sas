<?php

namespace App\Entity;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Repository\SystemParameterRepository;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\NumericValue;
use App\Traits\EntityFields\StringValue;
use App\Traits\EntityFields\TextValue;
use App\Traits\EntityFields\Token;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;

#[Module(title: 'System parameter', tab_order: [
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
#[Entity(repositoryClass: SystemParameterRepository::class)]
#[Index(columns: ['token'], name: 'token')]
class SystemParameter
{
    use Id, Token, StringValue, TextValue, NumericValue;
}
