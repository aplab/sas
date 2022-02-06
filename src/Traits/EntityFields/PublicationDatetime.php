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

trait PublicationDatetime
{
    #[Property(title: 'Publication datetime')]
    #[Cell(type: CellTypeDatetime::class, order: 2000, width: 180)]
    #[Widget(type: FieldTypeDateTimePicker::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'datetime', nullable: true)]
    protected ?DateTime $publicationDatetime = null;

    public function getPublicationDatetime(): DateTime|null
    {
        return $this->publicationDatetime;
    }

    public function setPublicationDatetime(DateTime|string|null $publicationDatetime): static
    {
        if ($publicationDatetime instanceof DateTime) {
            $this->publicationDatetime = $publicationDatetime;
        } else {
            $this->publicationDatetime = (new DateTime)->setTimestamp(strtotime($publicationDatetime));
        }
        return $this;
    }
}
