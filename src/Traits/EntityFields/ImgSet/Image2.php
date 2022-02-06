<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 1:36
 */

namespace App\Traits\EntityFields\ImgSet;

use App\Component\DataTableRepresentation\CellType\CellTypeImage;
use App\Component\InstanceEditor\FieldType\FieldTypeImage;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Traits\EntityFields\ImgSet\Helper\Thumbnail;
use Doctrine\ORM\Mapping\Column;

trait Image2
{
    use Thumbnail, Thumbnail2;

    #[Property(title: 'Image 2')]
    #[Cell(type: CellTypeImage::class, order: 3002, width: 48)]
    #[Widget(type: FieldTypeImage::class, order: 3002, tab: TabDef::IMAGE)]
    #[Column(type: 'string')]
    protected string $image2 = '';

    public function getImage2() :string
    {
        return $this->image2;
    }

    public function setImage2(string $image2) :self
    {
        $this->image2 = $image2;
        $this->setThumbnail2($this->thumbnail($image2));
        return $this;
    }
}
