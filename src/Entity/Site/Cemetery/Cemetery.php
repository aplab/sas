<?php

namespace App\Entity\Site\Cemetery;

use App\Component\DataTableRepresentation\CellType\CellTypeEntityId;
use App\Component\InstanceEditor\FieldType\FieldTypeEntityId;
use App\Component\ModuleMetadata as ModuleMetadata;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Entity\Site\City;
use App\Repository\Site\Cemetery\CemeteryRepository;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Address;
use App\Traits\EntityFields\Description;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\Phone;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

#[ModuleMetadata\Module(title: 'Кладбища', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Map' => 20000000,
    'Additional' => 30000418
])]
#[Entity(repositoryClass: CemeteryRepository::class)]
class Cemetery
{
    use Id, Name, Address, Phone, Active, Description;

    #[Property(title: 'City')]
    #[Cell(type: CellTypeEntityId::class, order: 3000, width: 320, options: ['accessor' => 'getName', 'data_class' => City::class])]
    #[Widget(type: FieldTypeEntityId::class, order: 2000, tab: TabDef::GENERAL, options: ['data_class' => City::class])]
    #[Column(type: 'bigint')]
    private int $cityId = 0;

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function setCityId(int $cityId): static
    {
        $this->cityId = $cityId;
        return $this;
    }
}
