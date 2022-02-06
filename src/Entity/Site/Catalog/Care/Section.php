<?php

namespace App\Entity\Site\Catalog\Care;

use App\Component\ModuleMetadata as ModuleMetadata;
use App\Repository\Site\Catalog\Care\SectionRepository;
use App\Traits\EntityFields\Active;
use App\Traits\EntityFields\Id;
use App\Traits\EntityFields\Name;
use App\Traits\EntityFields\SortOrder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[ModuleMetadata\Module(title: 'Уход разделы')]
#[Entity(repositoryClass: SectionRepository::class)]
#[Table(name: 'care_section')]
class Section
{
    use Id, Name, SortOrder, Active;

    #[OneToMany(mappedBy: 'section', targetEntity: Product::class)]
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSection($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getSection() === $this) {
                $product->setSection(null);
            }
        }

        return $this;
    }
}
