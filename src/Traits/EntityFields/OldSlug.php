<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:31
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait OldSlug
{
    #[Property(title: 'Old slug')]
    #[Cell(type: CellTypeLabel::class, order: 2010, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2010, tab: TabDef::GENERAL)]
    #[Column(type: 'string', length: 255)]
    protected string $oldSlug = '';

    public function getOldSlug(): string
    {
        return $this->oldSlug;
    }

    public function setOldSlug(string $oldSlug): static
    {
        $this->oldSlug = $oldSlug;
        return $this;
    }
}
