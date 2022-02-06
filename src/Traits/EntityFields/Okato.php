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

trait Okato
{
    #[Property(title: 'Okato')]
    #[Cell(type: CellTypeLabel::class, order: 2010, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2010, tab: TabDef::ADDITIONAL)]
    #[Column(type: 'string', length: 20, options: ['fixed' => true, 'default' => ''])]
    protected string $okato = '';

    public function getOkato(): string
    {
        return $this->okato;
    }

    public function setOkato(string $okato): static
    {
        $this->okato = $okato;
        return $this;
    }
}
