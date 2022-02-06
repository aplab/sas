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

trait Month
{
    #[Property(title: 'Month')]
    #[Cell(type: CellTypeRtext::class, order: 1001000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 1001000, tab: TabDef::GENERAL)]
    #[Column(type: 'bigint')]
    protected int $month = 0;

    public function getMonth(): int
    {
        return $this->month ?? 0;
    }

    public function setMonth(int $month): static
    {
        $this->month = $month ?? 0;
        return $this;
    }


}
