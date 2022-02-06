<?php

namespace App\Entity\Site;

use App\Component\DataTableRepresentation\CellType\CellTypeEditId;
use App\Component\DataTableRepresentation\CellType\CellTypeEntity;
use App\Component\DataTableRepresentation\CellType\CellTypeLabel;
use App\Component\DataTableRepresentation\CellType\CellTypeTree;
use App\Component\InstanceEditor\FieldType\FieldTypeEntity;
use App\Component\InstanceEditor\FieldType\FieldTypeLabel;
use App\Component\InstanceEditor\FieldType\FieldTypeText;
use App\Component\ModuleMetadata\Cell;
use App\Component\ModuleMetadata\Module;
use App\Component\ModuleMetadata\Property;
use App\Component\ModuleMetadata\TabDef;
use App\Component\ModuleMetadata\Widget;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Code;
use App\Traits\EntityFields\CreatedAt;
use App\Traits\EntityFields\HtmlTitle;
use App\Traits\EntityFields\LastModified;
use App\Traits\EntityFields\MetaDescription;
use App\Traits\EntityFields\MetaKeywords;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\SortOrder;
use App\Traits\EntityFields\Text;
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
use LogicException;

#[Module(title: 'Structure', tab_order: [
    'General' => 1000,
    'Text' => 2000,
    'Short' => 2100,
    'Full' => 2200,
    'Image' => 1000000,
    'SEO' => 10000000,
    'Map' => 20000000,
    'Additional' => 30000418
])]
#[Entity(repositoryClass: 'App\Repository\Site\SectionRepository')]
#[Index(columns: ["parent_id"], name: "parent_id")]
#[Index(columns: ["sort_order"], name: "sort_order")]
#[Index(columns: ["sort_order", "id"], name: "order_id")]
#[Index(columns: ["parent_id", "active"], name: "parent_active")]
#[Index(columns: ["active"], name: "active")]
#[Index(columns: ["code"], name: "code")]
class Section
{
    #[Property(title: 'ID', readonly: true)]
    #[Cell(type: CellTypeEditId::class, order: 1000, width: 80)]
    #[Widget(type: FieldTypeLabel::class, order: 1000, tab: TabDef::ADDITIONAL)]
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'bigint')]
    private $id;

    #[OneToMany(mappedBy: 'parent', targetEntity: '\App\Entity\Site\Section')]
    #[OrderBy(value: ['sortOrder' => 'ASC', 'id' => 'ASC'])]
    private $children;

    #[Property(title: 'Parent')]
    #[Cell(type: CellTypeEntity::class, order: 3000, width: 320, options: ['accessor' => 'getName'])]
    #[Widget(type: FieldTypeEntity::class, order: 2000, tab: TabDef::GENERAL, options: ['data_class' => Section::class])]
    #[ManyToOne(targetEntity: '\App\Entity\Site\Section', inversedBy: 'children')]
    #[JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private $parent;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->sortOrder = 0;
        $this->interesting = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
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

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
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

    public function removeChild(self $child): static
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

    use Name;
    use HtmlTitle;
    use Active;
    use SortOrder;
    use Text;
    use MetaDescription;
    use MetaKeywords;
    use CreatedAt;
    use LastModified;
    use Code;

    #[Property(title: 'Name')]
    #[Cell(type: CellTypeTree::class, order: 2000, width: 320)]
    #[Widget(type: FieldTypeText::class, order: 2000, tab: TabDef::GENERAL)]
    #[Column(type: 'string')]
    protected string $name = '';

    #[OneToMany(mappedBy: 'section', targetEntity: '\App\Entity\Site\Interesting')]
    private $interesting;

    public function getInteresting(): Collection
    {
        return $this->interesting;
    }

    public function addInteresting(Interesting $interesting): static
    {
        if (!$this->interesting->contains($interesting)) {
            $this->interesting[] = $interesting;
            $interesting->setSection($this);
        }
        return $this;
    }

    public function removeInteresting(Interesting $interesting): static
    {
        if ($this->interesting->contains($interesting)) {
            $this->interesting->removeElement($interesting);
            // set the owning side to null (unless already changed)
            if ($interesting->getSection() === $this) {
                $interesting->setSection(null);
            }
        }
        return $this;
    }
}
