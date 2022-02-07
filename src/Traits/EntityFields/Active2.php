<?php namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeActive;
use App\Component\InstanceEditor\FieldType\FieldTypeFlag;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Active2
{
    use Active;

    #[Property(title: 'Active')]
    #[Cell(type: CellTypeActive::class, order: 2000, width: 32)]
    #[Widget(type: FieldTypeFlag::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'boolean')]
    protected bool $active;
}
