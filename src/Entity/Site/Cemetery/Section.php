<?php

namespace App\Entity\Site\Cemetery;

use App\Component\DataTableRepresentation\CellType\CellTypeEntityId;
use App\Component\InstanceEditor\FieldType\FieldTypeEntityId;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Repository\Site\Cemetery\SectionRepository;
use App\Traits\EntityFields\CemeterySection\Number;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Label;
use App\Traits\EntityFields\LabelTmp;
use App\Traits\EntityFields\Name;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;


#[Module(title: 'Секции кладбища', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Map' => 20000000,
    'Additional' => 30000418
])]
#[Table(name: 'cemetery_section')]
#[Entity(repositoryClass: SectionRepository::class)]
class Section
{
    use Id, Name, Label, LabelTmp, Number;

    #[Property(title: 'Cemetery')]
    #[Cell(type: CellTypeEntityId::class, order: 2010, width: 320, options: ['accessor' => 'getName', 'data_class' => Cemetery::class])]
    #[Widget(type: FieldTypeEntityId::class, order: 2000, tab: TabDef::GENERAL, options: ['data_class' => Cemetery::class])]
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
