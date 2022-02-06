<?php

namespace App\Entity\Site;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\TabDef;
use App\Repository\Site\ReviewRepository;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Email;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\IpAddress;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\PublicationDatetime;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;

#[Module(title: 'Отзывы', tab_order: [
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
#[Entity(repositoryClass: ReviewRepository::class)]
#[Index(columns: ["active", "publication_datetime"], name: "site_list_items")]
#[Index(columns: ["active", "publication_datetime", "id"], name: "site_list_items_with_id")]
class Review
{
    use Id, Name, CreatedAtLastModified, \App\Traits\EntityFields\Comment, Email, IpAddress, PublicationDatetime, Active;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }
}
