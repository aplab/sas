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

trait Avatar
{
    #[Property(title: 'Avatar')]
    #[Cell(type: CellTypeImage::class, order: 1200, width: 48)]
    #[Widget(type: FieldTypeImage::class, order: 3000, tab: TabDef::IMAGE)]
    #[Column(type: 'string')]
    protected string $avatar = '';

    public function getAvatar() :string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar) :self
    {
        $this->avatar = $avatar;
        return $this;
    }
}
