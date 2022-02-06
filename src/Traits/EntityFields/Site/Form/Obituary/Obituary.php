<?php namespace App\Traits\EntityFields\Site\Form\Obituary;

use App\Component\DataTableRepresentation\CellType\CellTypeTextTooltip;
use App\Component\InstanceEditor\FieldType\FieldTypeTextareaDouble;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Obituary
{
    #[Property(title: 'Некролог')]
    #[Cell(type: CellTypeTextTooltip::class, order: 4000, width: 420)]
    #[Widget(type: FieldTypeTextareaDouble::class, order: 30000, tab: TabDef::GENERAL)]
    #[Column(type: 'text')]
    private string $obituary = '';

    public function getObituary(): string
    {
        return $this->obituary;
    }

    public function setObituary(string $obituary): static
    {
        $this->obituary = $obituary;
        return $this;
    }
}
