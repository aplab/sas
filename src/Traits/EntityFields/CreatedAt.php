<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 26.01.2019
 * Time: 15:35
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeDatetime;
use App\Component\InstanceEditor\FieldType\FieldTypeDateTime;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait CreatedAt
{
    #[Property(title: 'Created at', readonly: true)]
    #[Cell(type: CellTypeDatetime::class, order: 1000000000, width: 156)]
    #[Widget(type: FieldTypeDateTime::class, order: 1000000000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    protected $createdAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
