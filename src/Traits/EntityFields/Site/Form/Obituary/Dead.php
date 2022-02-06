<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields\Site\Form\Obituary;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Dead
{
    #[Property(title: 'Фио покойного')]
    #[Cell(type: CellTypeLabel::class, order: 4000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 4000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    protected string $dead = '';

    public function getDead(): string
    {
        return $this->dead;
    }

    public function setDead(string $dead): static
    {
        $this->dead = $dead;
        return $this;
    }
}
