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

trait SectionName
{
    #[Property(title: 'Section name')]
    #[Cell(type: CellTypeTextTooltip::class, order: 12000, width: 220)]
    #[Widget(type: FieldTypeText::class, order: 4000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'string')]
    protected string $sectionName = '';

    public function getSectionName(): string
    {
        return $this->sectionName;
    }

    public function setSectionName(string $sectionName): static
    {
        $this->sectionName = $sectionName;
        return $this;
    }
}
