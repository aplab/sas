<?php

namespace App\Entity\Site\Catalog\Flowers;

use App\Component\DataTableRepresentation\CellType\CellTypeEntity;
use App\Component\InstanceEditor\FieldType\FieldTypeEntity;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Repository\Site\Catalog\Flowers\ProductRepository;
use App\Service\ThumbnailGenerator;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Additional;
use App\Traits\EntityFields\Article;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\ImgSet\Image1;
use App\Traits\EntityFields\ImgSet\Image2;
use App\Traits\EntityFields\ImgSet\Image3;
use App\Traits\EntityFields\ImgSet\Image4;
use App\Traits\EntityFields\MoreImages;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\Popular;
use App\Traits\EntityFields\PriceString;
use App\Traits\EntityFields\Seo;
use App\Traits\EntityFields\Size;
use App\Traits\EntityFields\SortOrder;
use App\Traits\EntityFields\Text;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Module(title: 'Цветы венки')]
#[Entity(repositoryClass: ProductRepository::class)]
#[Table(name: 'flowers')]
class Product
{
    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    private static ?ThumbnailGenerator $thumbnailGenerator;

    use Id, Name, Additional, Article, Size, Image1, Image2, Image3, Image4, Seo, PriceString, SortOrder, Active, CreatedAtLastModified, MoreImages;

    #[Property(title: 'Section')]
    #[Cell(type: CellTypeEntity::class, order: 3000, width: 320, options: ['accessor' => 'getName'])]
    #[Widget(type: FieldTypeEntity::class, order: 2000, tab: TabDef::GENERAL, options: ['data_class' => Section::class])]
    #[ManyToOne(targetEntity: Section::class, inversedBy: 'products')]
    private ?Section $section = null;

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): static
    {
        $this->section = $section;

        return $this;
    }

    public static function setThumbnailGenerator(ThumbnailGenerator $t)
    {
        static::$thumbnailGenerator = $t;
    }

    public static function getThumbnailGenerator(): ?ThumbnailGenerator
    {
        return self::$thumbnailGenerator;
    }
}
