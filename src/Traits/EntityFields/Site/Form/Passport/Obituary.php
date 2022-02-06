<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:18
 */

namespace App\Traits\EntityFields\Site\Form\Passport;

use App\Component\DataTableRepresentation\CellType\CellTypeActive;
use App\Component\InstanceEditor\FieldType\FieldTypeFlag;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Obituary
{
    #[Property(title: 'Некролог')]
    #[Cell(type: CellTypeActive::class, order: 8000, width: 64)]
    #[Widget(type: FieldTypeFlag::class, order: 8000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'boolean')]
    protected bool $obituary = false;

    public function getObituary(): bool
    {
        return $this->obituary;
    }

    public function setObituary(mixed $obituary): static
    {
        $this->obituary = (bool)$obituary;
        return $this;
    }
}
