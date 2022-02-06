<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:18
 */

namespace App\Traits\EntityFields;
use App\Component\DataTableRepresentation\CellType\CellTypeActive;
use App\Component\InstanceEditor\FieldType\FieldTypeFlag;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait MoreImages
{
    #[Property(title: 'Доп. ряд фото')]
    #[Cell(type: CellTypeActive::class, order: 2000, width: 64)]
    #[Widget(type: FieldTypeFlag::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'boolean')]
    protected bool $moreImages = false;

    public function getMoreImages(): bool
    {
        return $this->moreImages;
    }

    public function setMoreImages($moreImages): static
    {
        $this->moreImages = (bool)$moreImages;
        return $this;
    }
}
