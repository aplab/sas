<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;


use App\Component\DataTableRepresentation\CellType\CellTypeIconVariants;
use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeIconSelector;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Icon
{
    #[Property(title: 'Icon')]
    #[Cell(type: CellTypeLabel::class, order: 2010, width: 220)]
    #[Cell(type: CellTypeIconVariants::class, order: 2010, width: 80, title: 'Preview')]
    #[Widget(type: FieldTypeIconSelector::class, order: 9000000000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    protected $icon;

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
}
