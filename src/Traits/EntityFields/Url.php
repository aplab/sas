<?php namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeRouteVariants;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Url
{
    #[Property(title: 'Url')]
    #[Cell(type: CellTypeLabel::class, order: 2000010, width: 200)]
    #[Widget(type: FieldTypeRouteVariants::class, order: 2000010, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    protected $url;

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = trim($url);
        return $this;
    }
}
