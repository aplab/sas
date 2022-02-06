<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields\Site\Burial;

use App\Component\DataTableRepresentation\CellType\CellTypeRtext;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Longitude
{
    #[Property(title: 'Longitude')]
    #[Cell(type: CellTypeRtext::class, order: 16000, width: 160)]
    #[Widget(type: FieldTypeText::class, order: 21000, tab: TabDef::MAP)]
    #[Column(type: 'decimal', precision: 15, scale: 12, options: ['default' => 0])]
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
