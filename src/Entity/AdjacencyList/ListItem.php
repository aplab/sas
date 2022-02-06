<?php namespace App\Entity\AdjacencyList;

use App\Component\DataTableRepresentation\CellType\CellTypeEditId;
use App\Component\DataTableRepresentation\CellType\CellTypeEntity;
use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\DataTableRepresentation\CellType\CellTypeRtext;
use App\Component\DataTableRepresentation\CellType\CellTypeTree;
use App\Component\InstanceEditor\FieldType\FieldTypeEntity;
use App\Component\InstanceEditor\FieldType\FieldTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Repository\AdjacencyListItemRepository;
use App\Traits\EntityFields\CreatedAtLastModified;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Mapping\Table;
use LogicException;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Module(title: 'Tree')]
#[Entity(repositoryClass: AdjacencyListItemRepository::class)]
#[Table(name: 'adjacency_list')]
#[Index(columns: ["parent_id"], name: "parent_id")]
#[Index(columns: ["sort_order"], name: "sort_order")]
#[Index(columns: ["sort_order", "id"], name: "order_id")]
class ListItem
{
    #[Property(title: 'ID', readonly: true)]
    #[Cell(type: CellTypeEditId::class, order: 1000, width: 80)]
    #[Widget(type: FieldTypeLabel::class, order: 1000, tab: TabDef::ADDITIONAL)]
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private $id;

    #[OneToMany(mappedBy: 'parent', targetEntity: '\App\Entity\AdjacencyList\ListItem')]
    #[OrderBy(value: ['sortOrder' => 'ASC', 'id' => 'ASC'])]
    private $children;

    #[Property(title: 'Parent')]
    #[Cell(type: CellTypeEntity::class, order: 3000, width: 320, options: ['accessor' => 'getName'])]
    #[Widget(type: FieldTypeEntity::class, order: 2000, tab: TabDef::GENERAL, options: ['data_class' => ListItem::class])]
    #[ManyToOne(targetEntity: '\App\Entity\AdjacencyList\ListItem', inversedBy: 'children')]
    #[JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private $parent;

    #[Property(title: 'Sort order')]
    #[Cell(type: CellTypeRtext::class, order: 4000, width: 120)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'bigint')]
    private $sortOrder;

    #[NotBlank(message: 'Name should be not blank')]
    #[Property(title: 'Name')]
    #[Cell(type: CellTypeTree::class, order: 2000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    private $name;

    public function __construct()
    {
        $this->createdAt = new DateTime;
        $this->updatedAt = new DateTime;
        $this->children = new ArrayCollection();
        $this->sortOrder = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ListItem[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(ListItem $child): static
    {
        if ($child === $this) {
            throw new LogicException('Unable to set object as child of itself.');
        }
        $parent_of_child = $child->getParent();
        while ($parent_of_child) {
            if ($parent_of_child === $this) {
                throw new LogicException('Unable to add ancestor as child.');
            }
        }
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(?ListItem $parent): static
    {
        if ($parent === $this) {
            throw new LogicException('Unable to set object as parent of itself.');
        }
        if (!is_null($parent)) {
            $parent_of_parent = $parent->getParent();
            while ($parent_of_parent) {
                if ($parent_of_parent === $this) {
                    throw new LogicException('Unable to set descendant as parent.');
                }
                $parent_of_parent = $parent_of_parent->getParent();
            }
        }
        $this->parent = $parent;
        return $this;
    }

    public function removeChild(ListItem $child): static
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder): static
    {
        $this->sortOrder = $sortOrder;
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

    use CreatedAtLastModified;
}
