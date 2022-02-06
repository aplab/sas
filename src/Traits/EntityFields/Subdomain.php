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

trait Subdomain
{
    #[Property(title: 'Subdomain')]
    #[Cell(type: CellTypeLabel::class, order: 2020, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2020, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'string', length: 120)]
    protected string $subdomain = '';

    public function getSubdomain(): string
    {
        return $this->subdomain;
    }

    public function setSubdomain(string $subdomain): static
    {
        $this->subdomain = $subdomain;
        return $this;
    }
}
