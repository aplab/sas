<?php namespace App\Traits\EntityFields\ImgSet;

use App\Component\DataTableRepresentation\CellType\CellTypeImage;
use App\Component\InstanceEditor\FieldType\FieldTypeImage;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Traits\EntityFields\ImgSet\Helper\Thumbnail;
use Doctrine\ORM\Mapping\Column;

trait Image3
{
    use Thumbnail, Thumbnail3;

    #[Property(title: 'Image 3')]
    #[Cell(type: CellTypeImage::class, order: 3003, width: 48)]
    #[Widget(type: FieldTypeImage::class, order: 3003, tab: TabDef::IMAGE)]
    #[Column(type: 'string')]
    protected string $image3 = '';

    public function getImage3() :string
    {
        return $this->image3;
    }

    public function setImage3(string $image3) :self
    {
        $this->image3 = $image3;
        $this->setThumbnail3($this->thumbnail($image3));
        return $this;
    }
}
