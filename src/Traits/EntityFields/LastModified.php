<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 26.01.2019
 * Time: 15:36
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeDatetime;
use App\Component\InstanceEditor\FieldType\FieldTypeDateTime;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait LastModified
{
    #[Property(title: 'Last modified', readonly: true)]
    #[Cell(type: CellTypeDatetime::class, order: 2000000000, width: 156)]
    #[Widget(type: FieldTypeDateTime::class, order: 2000000000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'datetime', nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'], columnDefinition: 'DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')]
    protected $lastModified;

    /**
     * @return mixed
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }
}
