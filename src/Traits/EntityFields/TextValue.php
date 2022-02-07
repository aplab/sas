<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use App\Component\DataTableRepresentation\CellType\CellTypeTextTooltip;
use App\Component\InstanceEditor\FieldType\FieldTypeTextarea;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait TextValue
{
    #[Property(title: 'Text value')]
    #[Cell(type: CellTypeTextTooltip::class, order: 3000, width: 320)]
    #[Widget(type: FieldTypeTextarea::class, order: 20000, tab: TabDef::GENERAL)]
    #[Column(type: 'text')]
    private string $textValue = '';

    public function getTextValue()
    {
        return $this->textValue;
    }

    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;
        return $this;
    }
}
