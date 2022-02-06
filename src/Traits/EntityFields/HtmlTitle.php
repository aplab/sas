<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 25.01.2019
 * Time: 0:23
 */

namespace App\Traits\EntityFields;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;

trait HtmlTitle
{
    #[Property(title: 'HTML title')]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::SEO)]
    #[Cell(type: CellTypeLabel::class, order: 3000, width: 320)]
    #[Column(type: 'string')]
    protected string $htmlTitle = '';

    public function getHtmlTitle(): string
    {
        return $this->htmlTitle;
    }

    public function setHtmlTitle(string $htmlTitle): static
    {
        $this->htmlTitle = $htmlTitle;
        return $this;
    }
}
