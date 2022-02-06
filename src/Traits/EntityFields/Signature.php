<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeTextarea;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Signature
{
    #[Property(title: 'Signature')]
    #[Cell(type: CellTypeLabel::class, order: 3000, width: 320)]
    #[Widget(type: FieldTypeTextarea::class, order: 20000, tab: TabDef::GENERAL)]
    #[Column(type: 'text')]
    private string $signature = '';

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function setSignature($signature): static
    {
        $this->signature = $signature;
        return $this;
    }
}
