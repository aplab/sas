<?php namespace App\Traits\EntityFields;
use App\Component\DataTableRepresentation\CellType\CellTypeActive;
use App\Component\InstanceEditor\FieldType\FieldTypeFlag;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Active
{
    #[Property(title: 'Active')]
    #[Cell(type: CellTypeActive::class, order: 2000, width: 64)]
    #[Widget(type: FieldTypeFlag::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'boolean')]
    protected bool $active = false;

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive($active): static
    {
        $this->active = (bool)$active;
        return $this;
    }
}
