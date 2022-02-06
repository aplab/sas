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

trait BirthYear
{
    #[Property(title: 'Birth year')]
    #[Cell(type: CellTypeRtext::class, order: 7000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 2000000, tab: TabDef::GENERAL)]
    #[Column(type: 'smallint')]
    protected ?int $birthYear = null;

    public function getBirthYear(): ?int
    {
        return $this->birthYear;
    }

    public function setBirthYear(?int $birthYear): static
    {
        $this->birthYear = $birthYear;
        return $this;
    }


}
