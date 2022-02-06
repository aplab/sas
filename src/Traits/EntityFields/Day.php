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

trait Day
{
    #[Property(title: 'Day')]
    #[Cell(type: CellTypeRtext::class, order: 1000000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 1000000, tab: TabDef::GENERAL)]
    #[Column(type: 'bigint')]
    protected int $day = 0;

    public function getDay(): int
    {
        return $this->day ?? 0;
    }

    public function setDay(int $day): static
    {
        $this->day = $day ?? 0;
        return $this;
    }


}
