<?php

namespace App\Entity\Site\Catalog\Care;

use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Repository\Site\Catalog\Care\ProductRepository;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Additional;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\Popular;
use App\Traits\EntityFields\PriceString;
use App\Traits\EntityFields\Seo;
use App\Traits\EntityFields\SortOrder;
use App\Traits\EntityFields\Text;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Module(title: 'Уход')]
#[Entity(repositoryClass: ProductRepository::class)]
#[Table(name: 'care')]
class Product
{
    use Id, Name, Additional, Popular, Seo, PriceString, Text, SortOrder, Active, CreatedAtLastModified;

    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    #[Property(title: 'Section')]
//    #[Cell(type: CellTypeEntity::class, order: 3000, width: 320, options: ['accessor' => 'getName'])]
//    #[Widget(type: FieldTypeEntity::class, order: 2000, tab: TabDef::GENERAL, options: ['data_class' => Section::class])]
    #[ManyToOne(targetEntity: Section::class, inversedBy: 'products')]
    private ?Section $section = null;

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): static
    {
        $this->section = $section;

        return $this;
    }
}
