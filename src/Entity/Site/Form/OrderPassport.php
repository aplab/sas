<?php

namespace App\Entity\Site\Form;

use App\Component\DataTableRepresentation\CellType\CellTypeEntityId;
use App\Component\InstanceEditor\FieldType\FieldTypeEntityId;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Entity\Site\Cemetery\Cemetery;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Site\Form\Order\Active;
use App\Traits\EntityFields\Site\Form\Passport\Client;
use App\Traits\EntityFields\Site\Form\Passport\Dead;
use App\Traits\EntityFields\Site\Form\Passport\Email;
use App\Traits\EntityFields\Site\Form\Passport\Obituary;
use App\Traits\EntityFields\Site\Form\Passport\Phone;
use App\Traits\EntityFields\Site\Form\Passport\Photo;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

#[Module(title: 'Форма заявки', tab_order: [
    TabDef::GENERAL => 1000,
    TabDef::TEXT => 2000,
    TabDef::SHORT => 2100,
    TabDef::FULL => 2200,
    TabDef::IMAGE => 1000000,
    TabDef::SEO => 10000000,
    TabDef::ADDITIONAL => 10000418,
])]
#[Entity(repositoryClass: 'App\Repository\Site\Form\OrderPassportRepository')]
class OrderPassport
{
    use Id, Client, Email, Phone, Dead, Obituary, Photo, Active, CreatedAtLastModified;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    #[Property(title: 'Cemetery')]
    #[Cell(type: CellTypeEntityId::class, order: 2000000, width: 220, options: ['accessor' => 'getName', 'data_class' => Cemetery::class])]
    #[Widget(type: FieldTypeEntityId::class, order: 2000000, tab: TabDef::GENERAL, options: ['data_class' => Cemetery::class])]
    #[Column(type: 'bigint', nullable: true)]
    private ?int $cemeteryId = null;

    public function getCemeteryId(): ?int
    {
        return $this->cemeteryId;
    }

    public function setCemeteryId(?int $cemeteryId): static
    {
        $this->cemeteryId = $cemeteryId;
        return $this;
    }
}
