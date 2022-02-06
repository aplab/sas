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

trait PhotoPath1
{
    #[Property(title: 'Photo 1')]
    #[Cell(type: CellTypeTextTooltip::class, order: 17000, width: 220)]
    #[Widget(type: FieldTypeText::class, order: 1000, tab: TabDef::IMAGE)]
    #[Column(type: 'string')]
    protected string $photoPath1 = '';

    public function getPhotoPath1(): string
    {
        return $this->photoPath1;
    }

    public function setPhotoPath1(string $photoPath1): static
    {
        $this->photoPath1 = $photoPath1;
        return $this;
    }
}
