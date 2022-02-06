<?php namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeTextTooltip;
use App\Component\InstanceEditor\FieldType\FieldTypeTextareaDouble;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Comment
{
    #[Property(title: 'Comment')]
    #[Cell(type: CellTypeTextTooltip::class, order: 4000, width: 420)]
    #[Widget(type: FieldTypeTextareaDouble::class, order: 30000, tab: TabDef::GENERAL)]
    #[Column(type: 'text')]
    private string $comment = '';

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }
}
