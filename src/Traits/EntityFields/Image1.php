<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 1:36
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeImage;
use App\Component\InstanceEditor\FieldType\FieldTypeImage;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Image1
{
    #[Property(title: 'Image 1')]
    #[Cell(type: CellTypeImage::class, order: 3000, width: 48)]
    #[Widget(type: FieldTypeImage::class, order: 3000, tab: TabDef::IMAGE)]
    #[Column(type: 'string')]
    protected string $image1 = '';

    public function getImage1() :string
    {
        return $this->image1;
    }

    public function setImage1(string $image1) :self
    {
        $this->image1 = $image1;
        return $this;
    }
}
