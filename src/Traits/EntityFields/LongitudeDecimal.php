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

trait LongitudeDecimal
{
    #[Property(title: 'Longitude')]
    #[Cell(type: CellTypeRtext::class, order: 21000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 21000, tab: TabDef::MAP)]
    #[Column(type: 'decimal', precision: 10, scale: 6, options: ['default' => 0])]
    protected string $longitude = '0';

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;
        return $this;
    }
}
