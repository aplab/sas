<?php
/**
 * Created by PhpStorm.
 * User: polyanin
 * Date: 10.09.2018
 * Time: 16:44
 */

namespace App\Entity\Bind;

use App\Component\DataTableRepresentation\CellType\CellTypeEditId;
use App\Component\DataTableRepresentation\CellType\CellTypeEntity;
use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeEntity;
use App\Component\InstanceEditor\FieldType\FieldTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * Class Contained
 * @package App\Entity\Bind
 */
#[Module(title: 'Contained', description: 'Contained entity')]
#[Entity(repositoryClass: 'App\Repository\BindContainedRepository')]
#[Table(name: 'bind_contained')]
class Contained
{
    #[Property(title: 'ID', readonly: true)]
    #[Cell(type: CellTypeEditId::class, order: 1000, width: 80)]
    #[Widget(type: FieldTypeLabel::class, order: 1000, tab: TabDef::ADDITIONAL)]
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'bigint')]
    private ?int $id = null;

    #[Property(title: 'Name')]
    #[Cell(type: CellTypeLabel::class, order: 2000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    private string $name = '';

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Contained
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): static
    {
        $this->name = $name;
        return $this;
    }

    #[Property(title: 'Container')]
    #[Cell(type: CellTypeEntity::class, order: 3000, width: 320, options: ['accessor' => "getName"])]
    #[Widget(type: FieldTypeEntity::class, order: 2000, tab: TabDef::GENERAL, options: ['data_class' => Container::class])]
    #[ManyToOne(targetEntity: '\App\Entity\Bind\Container', inversedBy: 'contained')]
    #[JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private mixed $container;

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(?Container $container): static
    {
        $this->container = $container;
        return $this;
    }
}
