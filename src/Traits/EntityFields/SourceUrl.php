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

trait SourceUrl
{
    #[Property(title: 'Source Url')]
    #[Cell(type: CellTypeLabel::class, order: 2000010, width: 200)]
    #[Widget(type: FieldTypeText::class, order: 2000010, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    protected string $sourceUrl = '';

    public function getSourceUrl(): string
    {
        return $this->sourceUrl;
    }

    public function setSourceUrl(string $sourceUrl): static
    {
        $this->sourceUrl = $sourceUrl;
        return $this;
    }
}
