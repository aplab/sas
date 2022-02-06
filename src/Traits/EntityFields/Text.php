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

trait Text
{
    #[Property(title: 'Text')]
    #[Widget(type: FieldTypeCkeditor::class, order: 2000, tab: TabDef::TEXT)]
    #[Column(type: 'text')]
    protected string $text = '';

    public function getText() :?string
    {
        return $this->text;
    }

    public function setText(string $text) : static
    {
        $this->text = $text;
        return $this;
    }
}
