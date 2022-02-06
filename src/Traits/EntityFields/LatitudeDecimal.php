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

trait LatitudeDecimal
{
    #[Property(title: 'Latitude')]
    #[Cell(type: CellTypeRtext::class, order: 20000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 20000, tab: TabDef::MAP)]
    #[Column(type: 'decimal', precision: 10, scale: 6, options: ['default' => 0])]
    protected string $latitude = '0';

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;
        return $this;
    }
}
