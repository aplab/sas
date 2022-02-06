<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:18
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeActive;
use App\Component\InstanceEditor\FieldType\FieldTypeFlag;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait IsDefault
{
    #[Property(title: 'Default')]
    #[Cell(type: CellTypeActive::class, order: 2000, width: 64)]
    #[Widget(type: FieldTypeFlag::class, order: 2000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'boolean')]
    protected bool $isDefault = false;

    public function getIsDefault(): bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(mixed $isDefault): static
    {
        $this->isDefault = (bool)$isDefault;
        return $this;
    }
}
