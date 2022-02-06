<?php namespace App\Entity\Bind;

use App\Component\DataTableRepresentation\CellType\CellTypeEditId;
use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Module(title: 'Container', description: 'Container entity')]
#[Entity(repositoryClass: 'App\Repository\BindContainerRepository')]
#[Table(name: 'bind_container')]
class Container
{
    #[Property(title: 'ID', readonly: true)]
    #[Cell(type: CellTypeEditId::class, order: 1000, width: 80)]
    #[Widget(type: FieldTypeLabel::class, order: 1000, tab: TabDef::ADDITIONAL)]
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'bigint')]
    private $id;

    #[Property(title: 'Name')]
    #[Cell(type: CellTypeLabel::class, order: 2000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    private $name;

    public function getId(): mixed
    {
        return $this->id;
    }

    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function setName(mixed $name): static
    {
        $this->name = $name;
        return $this;
    }

    #[OneToMany(mappedBy: 'container', targetEntity: '\App\Entity\Bind\Contained')]
    private $contained;

    public function __construct()
    {
        $this->contained = new ArrayCollection();
    }

    public function getContained(): Collection
    {
        return $this->contained;
    }

    public function addContained(Contained $contained): static
    {
        if (!$this->contained->contains($contained)) {
            $this->contained[] = $contained;
            $contained->setContainer($this);
        }
        return $this;
    }

    public function removeContained(Contained $contained): static
    {
        if ($this->contained->contains($contained)) {
            $this->contained->removeElement($contained);
            // set the owning side to null (unless already changed)
            if ($contained->getContainer() === $this) {
                $contained->setContainer(null);
            }
        }
        return $this;
    }
}
