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

trait Text2
{
    #[Property(title: 'Full')]
    #[Widget(type: FieldTypeCkeditor::class, order: 2000, tab: TabDef::FULL)]
    #[Column(type: 'text')]
    protected string $text2 = '';

    public function getText2(): string
    {
        return $this->text2;
    }

    public function setText2(string $text2): static
    {
        $this->text2 = $text2;
        return $this;
    }
}
