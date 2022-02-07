<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use App\Component\DataTableRepresentation\CellType\CellTypeRtext;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait NumericValue
{
    #[Property(title: 'Numeric value')]
    #[Cell(type: CellTypeRtext::class, order: 2000000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 2000000, tab: TabDef::GENERAL)]
    #[Column(type: 'integer')]
    protected int $numericValue = 0;

    public function getNumericValue(): int
    {
        return $this->numericValue ?? 0;
    }

    public function setNumericValue(int $numericValue): self
    {
        $this->numericValue = (int)$numericValue ?? 0;
        return $this;
    }


}
