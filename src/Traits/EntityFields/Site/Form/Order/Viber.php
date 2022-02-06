<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:18
 */

namespace App\Traits\EntityFields\Site\Form\Order;

use App\Component\DataTableRepresentation\CellType\CellTypeActive;
use App\Component\InstanceEditor\FieldType\FieldTypeFlag;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Viber
{
    #[Property(title: 'Viber')]
    #[Cell(type: CellTypeActive::class, order: 8000, width: 64)]
    #[Widget(type: FieldTypeFlag::class, order: 8000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'boolean')]
    protected bool $viber = false;

    public function getViber(): bool
    {
        return $this->viber;
    }

    public function setViber(mixed $viber): static
    {
        $this->viber = (bool)$viber;
        return $this;
    }
}
