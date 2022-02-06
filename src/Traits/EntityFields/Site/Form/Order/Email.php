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

trait Email
{
    #[Property(title: 'Email')]
    #[Cell(type: CellTypeActive::class, order: 7000, width: 64)]
    #[Widget(type: FieldTypeFlag::class, order: 7000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'boolean')]
    protected bool $email = false;

    public function getEmail(): bool
    {
        return $this->email;
    }

    public function setEmail(mixed $email): static
    {
        $this->email = (bool)$email;
        return $this;
    }
}
