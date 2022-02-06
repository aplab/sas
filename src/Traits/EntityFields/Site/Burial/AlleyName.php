<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields\Site\Burial;

use App\Component\DataTableRepresentation\CellType\CellTypeTextTooltip;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait AlleyName
{
    #[Property(title: 'Alley name')]
    #[Cell(type: CellTypeTextTooltip::class, order: 13000, width: 220)]
    #[Widget(type: FieldTypeText::class, order: 5000, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'string')]
    protected string $alleyName = '';

    public function getAlleyName(): string
    {
        return $this->alleyName;
    }

    public function setAlleyName(string $alleyName): static
    {
        $this->alleyName = $alleyName;
        return $this;
    }
}
