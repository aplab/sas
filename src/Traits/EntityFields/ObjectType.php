<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait ObjectType
{
    #[Property(title: 'Object Type')]
    #[Cell(type: CellTypeLabel::class, order: 20000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 20000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'string')]
    protected string $objectType = '';

    public function getObjectType(): string
    {
        return $this->objectType;
    }

    public function setObjectType(string $objectType): static
    {
        $this->objectType = $objectType;
        return $this;
    }
}
