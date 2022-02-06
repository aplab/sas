<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:27
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeDatetime;
use App\Component\InstanceEditor\FieldType\FieldTypeDateTimePicker;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use DateTime;
use Doctrine\ORM\Mapping\Column;

trait Birthdate
{
    #[Property(title: 'Birthdate')]
    #[Cell(type: CellTypeDatetime::class, order: 2000, width: 180)]
    #[Widget(type: FieldTypeDateTimePicker::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'datetime', nullable: true)]
    protected ?DateTime $birthdate = null;

    public function getBirthdate(): DateTime|null
    {
        return $this->birthdate;
    }

    public function setBirthdate(DateTime|string|null $birthdate): static
    {
        if (!$birthdate) {
            $this->birthdate = null;
            return $this;
        }
        if ($birthdate instanceof DateTime) {
            $this->birthdate = $birthdate;
        } else {
            $this->birthdate = (new DateTime)->setTimestamp(strtotime($birthdate));
        }
        return $this;
    }
}
