<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:27
 */

namespace App\Traits\EntityFields\Site\File;

use App\Component\DataTableRepresentation\CellType\CellTypeDatetime;
use App\Component\InstanceEditor\FieldType\FieldTypeDateTimePicker;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use DateTime;
use Doctrine\ORM\Mapping\Column;

trait Created
{
    #[Property(title: 'Created')]
    #[Cell(type: CellTypeDatetime::class, order: 2000, width: 180)]
    #[Widget(type: FieldTypeDateTimePicker::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    protected DateTime $created;

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime|string $created): static
    {
        if ($created instanceof DateTime) {
            $this->created = $created;
        } else {
            $this->created = (new DateTime)->setTimestamp(strtotime($created));
        }
        return $this;
    }
}
