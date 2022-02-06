<?php namespace App\Traits\EntityFields\Site\Form\Feedback;

use App\Component\DataTableRepresentation\CellType\CellTypeTextTooltip;
use App\Component\InstanceEditor\FieldType\FieldTypeTextareaDouble;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Message
{
    #[Property(title: 'Сообщение')]
    #[Cell(type: CellTypeTextTooltip::class, order: 4000, width: 420)]
    #[Widget(type: FieldTypeTextareaDouble::class, order: 30000, tab: TabDef::GENERAL)]
    #[Column(type: 'text')]
    private string $message = '';

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }
}
