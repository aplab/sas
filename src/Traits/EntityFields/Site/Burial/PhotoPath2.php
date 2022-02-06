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

trait PhotoPath2
{
    #[Property(title: 'Photo 2')]
    #[Cell(type: CellTypeTextTooltip::class, order: 18000, width: 220)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::IMAGE)]
    #[Column(type: 'string')]
    protected string $photoPath2 = '';

    public function getPhotoPath2(): string
    {
        return $this->photoPath2;
    }

    public function setPhotoPath2(string $photoPath2): static
    {
        $this->photoPath2 = $photoPath2;
        return $this;
    }
}
