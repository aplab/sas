<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields\Site\Form\Order;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Messenger
{
    #[Property(title: 'Инфо')]
    #[Cell(type: CellTypeLabel::class, order: 9000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 9000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    protected string $messenger = '';

    public function getMessenger(): string
    {
        return $this->messenger;
    }

    public function setMessenger(string $messenger): static
    {
        $this->messenger = $messenger;
        return $this;
    }
}
