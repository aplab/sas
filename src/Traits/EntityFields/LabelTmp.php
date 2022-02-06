<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait LabelTmp
{
    #[Property(title: 'Label Tmp')]
    #[Cell(type: CellTypeLabel::class, order: 2010, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2010, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'string')]
    protected string $labelTmp = '';

    public function getLabelTmp(): string
    {
        return $this->labelTmp;
    }

    public function setLabelTmp(string $labelTmp): static
    {
        $this->labelTmp = $labelTmp;
        return $this;
    }
}
