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

trait BirthDate
{
    #[Property(title: 'Birth Date')]
    #[Cell(type: CellTypeDate::class, order: 6000, width: 100)]
    #[Widget(type: FieldTypeDateTimePicker::class, order: 5000, tab: TabDef::GENERAL)]
    #[Column(type: 'date', nullable: true, options: ['default' => null])]
    protected ?DateTime $birthDate = null;

    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTime|string|null $birthDate): static
    {
        if ($birthDate instanceof DateTime) {
            $this->birthDate = $birthDate;
            return $this;
        }
        if (is_null($birthDate)) {
            $this->birthDate = $birthDate;
            return $this;
        }
        $timestamp = strtotime($birthDate);
        if ($timestamp) {
            $this->birthDate = new DateTime;
            $this->birthDate->setTimestamp($timestamp);
            return $this;
        }
        $this->birthDate = null;
        return $this;
    }
}
