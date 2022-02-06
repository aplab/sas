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

trait UpLevelPage
{
    #[Property(title: 'Up level page')]
    #[Cell(type: CellTypeRtext::class, order: 2000000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 2000000, tab: TabDef::GENERAL)]
    #[Column(type: 'bigint', nullable: true)]
    protected int $upLevelPage = 0;

    public function getUpLevelPage(): int
    {
        return $this->upLevelPage;
    }

    public function setUpLevelPage(int $upLevelPage): static
    {
        $this->upLevelPage = $upLevelPage;
        return $this;
    }
}
