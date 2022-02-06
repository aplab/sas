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
use App\Traits\EntityFields\Active as a;

trait Active
{
    use a;

    #[Property(title: 'Active')]
    #[Cell(type: CellTypeActive::class, order: 1500, width: 64)]
    #[Widget(type: FieldTypeFlag::class, order: 1500, tab: TabDef::GENERAL)]
    #[Column(type: 'boolean')]
    protected bool $active = false;
}
