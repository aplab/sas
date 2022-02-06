<?php namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeTextTooltip;
use App\Component\InstanceEditor\FieldType\FieldTypeTextarea;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Description
{
    #[Property(title: 'Description')]
    #[Cell(type: CellTypeTextTooltip::class, order: 4000, width: 420)]
    #[Widget(type: FieldTypeTextarea::class, order: 30000, tab: TabDef::GENERAL)]
    #[Column(type: 'text')]
    private string $description = '';

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }
}
