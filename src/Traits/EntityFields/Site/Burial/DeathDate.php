<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:27
 */

namespace App\Traits\EntityFields\Site\Burial;

use App\Component\DataTableRepresentation\CellType\CellTypeDate;
use App\Component\InstanceEditor\FieldType\FieldTypeDateTimePicker;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use DateTime;
use Doctrine\ORM\Mapping\Column;

trait DeathDate
{
    #[Property(title: 'Death Date')]
    #[Cell(type: CellTypeDate::class, order: 8000, width: 100)]
    #[Widget(type: FieldTypeDateTimePicker::class, order: 6000, tab: TabDef::GENERAL)]
    #[Column(type: 'date', nullable: true, options: ['default' => null])]
    protected ?DateTime $deathDate = null;

    public function getDeathDate(): ?DateTime
    {
        return $this->deathDate;
    }

    public function setDeathDate(DateTime|string|null $deathDate): static
    {
        if ($deathDate instanceof DateTime) {
            $this->deathDate = $deathDate;
            return $this;
        }
        if (is_null($deathDate)) {
            $this->deathDate = $deathDate;
            return $this;
        }
        $timestamp = strtotime($deathDate);
        if ($timestamp) {
            $this->deathDate = new DateTime;
            $this->deathDate->setTimestamp($timestamp);
            return $this;
        }
        $this->deathDate = null;
        return $this;
    }
}
