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

trait DeathYear
{
    #[Property(title: 'Death year')]
    #[Cell(type: CellTypeRtext::class, order: 9000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 2000000, tab: TabDef::GENERAL)]
    #[Column(type: 'smallint')]
    protected ?int $deathYear = null;

    public function getDeathYear(): ?int
    {
        return $this->deathYear;
    }

    public function setDeathYear(?int $deathYear): static
    {
        $this->deathYear = $deathYear;
        return $this;
    }


}
