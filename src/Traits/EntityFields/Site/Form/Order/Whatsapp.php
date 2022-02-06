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

trait Whatsapp
{
    #[Property(title: 'Whatsapp')]
    #[Cell(type: CellTypeActive::class, order: 6000, width: 64)]
    #[Widget(type: FieldTypeFlag::class, order: 6000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'boolean')]
    protected bool $whatsapp = false;

    public function getWhatsapp(): bool
    {
        return $this->whatsapp;
    }

    public function setWhatsapp(mixed $whatsapp): static
    {
        $this->whatsapp = (bool)$whatsapp;
        return $this;
    }
}
