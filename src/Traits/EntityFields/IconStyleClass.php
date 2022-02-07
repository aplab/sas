<?php namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeIconVariants;
use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeIconSelector;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

trait IconStyleClass
{
    #[Property(title: 'Icon style class')]
    #[Cell(type: CellTypeLabel::class, order: 2010, width: 220)]
    #[Cell(type: CellTypeIconVariants::class, order: 2010, width: 80)]
    #[Widget(type: FieldTypeText::class, order: 9000000000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'string')]
    protected $iconStyleClass;

    public function getIconStyleClass()
    {
        return $this->iconStyleClass;
    }

    public function setIconStyleClass($iconStyleClass)
    {
        $this->iconStyleClass = $iconStyleClass;
        return $this;
    }
}
