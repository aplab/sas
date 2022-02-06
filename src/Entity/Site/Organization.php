<?php

namespace App\Entity\Site;

use App\Component\ModuleMetadata\Module;
use App\Repository\Site\OrganizationRepository;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'Организация', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    use Id, Name;
}
