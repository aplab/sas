<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:33
 */

namespace App\Traits\EntityFields;

use App\Component\InstanceEditor\FieldType\FieldTypeCkeditor;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Text1
{
    #[Property(title: 'Short')]
    #[Widget(type: FieldTypeCkeditor::class, order: 2000, tab: TabDef::SHORT)]
    #[Column(type: 'text')]
    protected string $text1 = '';

    public function getText1() :string
    {
        return $this->text1;
    }

    public function setText1(string $text1) : static
    {
        $this->text1 = $text1;
        return $this;
    }
}
