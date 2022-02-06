<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:33
 */

namespace App\Traits\EntityFields\Site\Burial;

use App\Component\InstanceEditor\FieldType\FieldTypeCkeditor;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait Obituary
{
    #[Property(title: 'Некролог')]
    #[Widget(type: FieldTypeCkeditor::class, order: 2000, tab: 'Obituary')]
    #[Column(type: 'text')]
    protected string $obituary = '';

    public function getObituary() :?string
    {
        return $this->obituary;
    }

    public function setObituary(string $obituary) : static
    {
        $this->obituary = $obituary;
        return $this;
    }
}
