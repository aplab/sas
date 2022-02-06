<?php namespace App\Entity;

use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeLabel;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Module(title: 'Test entity title', description: 'Test entity description', tab_order: [
    'General' => 1000,
    'Photo' => 3000,
    'Contact' => 4000,
    'SEO' => 5000,
    'SEO2' => 5000,
    'Additional' => 10000418
])]
#[Entity(repositoryClass: 'App\Repository\SampleEntityRepository')]
#[Table(name: 'my_sample_entity')]
class SampleEntity
{
    #[Property(title: 'ID')]
    #[Cell(type: CellTypeLabel::class, order: 1000, width: 60)]
    #[Cell(type: CellTypeLabel::class, order: 2000, width: 200)]
    #[Widget(type: FieldTypeLabel::class, order: 1000, tab: TabDef::GENERAL, options: ['test'=>['a'=>234]])]
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'bigint')]
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
