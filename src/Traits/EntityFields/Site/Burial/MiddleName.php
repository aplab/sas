<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields\Site\Burial;

use App\Component\DataTableRepresentation\CellType\CellTypeTextTooltip;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait MiddleName
{
    #[Property(title: 'Middle name')]
    #[Cell(type: CellTypeTextTooltip::class, order: 3000, width: 220)]
    #[Widget(type: FieldTypeText::class, order: 3000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    protected string $middleName = '';

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): static
    {
        $this->middleName = $middleName;
        return $this;
    }
}
