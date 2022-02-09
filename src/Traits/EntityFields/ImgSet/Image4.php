<?php namespace App\Traits\EntityFields\ImgSet;

use App\Component\DataTableRepresentation\CellType\CellTypeImage;
use App\Component\InstanceEditor\FieldType\FieldTypeImage;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Traits\EntityFields\ImgSet\Helper\Thumbnail;
use Doctrine\ORM\Mapping\Column;

trait Image4
{
    use Thumbnail, Thumbnail4;

    #[Property(title: 'Image 4')]
    #[Cell(type: CellTypeImage::class, order: 3004, width: 48)]
    #[Widget(type: FieldTypeImage::class, order: 3004, tab: TabDef::IMAGE)]
    #[Column(type: 'string')]
    protected string $image4 = '';

    public function getImage4() :string
    {
        return $this->image4;
    }

    public function setImage4(string $image4) :self
    {
        $this->image4 = $image4;
        $this->setThumbnail4($image4);
        return $this;
    }
}
