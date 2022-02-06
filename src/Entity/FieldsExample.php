<?php namespace App\Entity;

use App\Component\DataTableRepresentation\CellType\CellTypeActive;
use App\Component\InstanceEditor\FieldType\FieldTypeFlag;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Traits\EntityFields\CreatedAtLastModified;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Image;
use App\Traits\EntityFields\Image2;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\Text;
use App\Traits\EntityFields\Textarea;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Module(title: 'Fields example', description: 'Fields example entity', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: 'App\Repository\FieldsExampleRepository')]
#[Table(name: 'fields_example')]
class FieldsExample
{
    public function __construct()
    {
        $this->createdAt = new DateTime;
    }

    #[Property(title: 'Flag')]
    #[Cell(type: CellTypeActive::class, order: 2000, width: 48)]
    #[Widget(type: FieldTypeFlag::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'boolean')]
    private $flag;

    public function getFlag()
    {
        return $this->flag;
    }

    public function setFlag($flag): static
    {
        $this->flag = !!$flag;
        return $this;
    }

    use Id, Textarea, Image, Image2, CreatedAtLastModified, Name, Text;
}
