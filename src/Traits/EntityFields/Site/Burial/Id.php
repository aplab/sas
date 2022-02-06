<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:30
 */

namespace App\Traits\EntityFields\Site\Burial;

use App\Component\DataTableRepresentation\CellType\CellTypeEditIdWide;
use App\Component\InstanceEditor\FieldType\FieldTypeId;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

trait Id
{
    #[Property(title: 'ID', readonly: true)]
    #[Cell(type: CellTypeEditIdWide::class, order: 1000, width: 120)]
    #[Widget(type: FieldTypeId::class, order: 1000, tab: TabDef::ADDITIONAL)]
    #[\Doctrine\ORM\Mapping\Id]
    #[GeneratedValue]
    #[Column(type: 'bigint')]
    protected ?int $id = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
