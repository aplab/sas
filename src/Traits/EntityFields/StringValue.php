<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use App\Component\DataTableRepresentation\CellType\CellTypeTextTooltip;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait StringValue
{
    #[Property(title: 'String value')]
    #[Cell(type: CellTypeTextTooltip::class, order: 2000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    protected string $stringValue = '';

    public function getStringValue(): string
    {
        return $this->stringValue;
    }

    public function setStringValue($stringValue): self
    {
        $this->stringValue = $stringValue;
        return $this;
    }
}
