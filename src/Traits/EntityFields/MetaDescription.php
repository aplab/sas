<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:33
 */

namespace App\Traits\EntityFields;

use App\Component\InstanceEditor\FieldType\FieldTypeTextarea;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait MetaDescription
{
    #[Property(title: 'Meta description')]
    #[Widget(type: FieldTypeTextarea::class, order: 3000, tab: TabDef::SEO)]
    #[Column(type: 'text')]
    protected string $metaDescription = '';

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): static
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }
}
