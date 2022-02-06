<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields\Site\Burial;

use App\Component\DataTableRepresentation\CellType\CellTypeRtext;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Age
{
    #[Property(title: 'Age')]
    #[Cell(type: CellTypeRtext::class, order: 10000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 2000000, tab: TabDef::GENERAL)]
    #[Column(type: 'smallint')]
    protected ?int $age = null;

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;
        return $this;
    }


}
