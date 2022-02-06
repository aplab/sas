<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeRtext;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait ObjectId
{
    #[Property(title: 'Object ID')]
    #[Cell(type: CellTypeRtext::class, order: 2000000000,width: 120)]
    #[Widget(type: FieldTypeText::class, order: 2000000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'bigint')]
    protected int $objectId = 0;

    public function getObjectId(): int
    {
        return $this->objectId;
    }

    public function setObjectId(int $objectId): static
    {
        $this->objectId = $objectId;
        return $this;
    }


}
