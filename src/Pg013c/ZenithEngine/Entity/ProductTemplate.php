<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Pg013c\ZenithEngine\Repository\ProductTemplateRepository;

#[ORM\Entity(repositoryClass: ProductTemplateRepository::class)]
class ProductTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    /**
     * @var Collection<int, ProductCategory>
     */
    #[ORM\OneToMany(targetEntity: ProductCategory::class, mappedBy: 'productTemplate')]
    private Collection $productCategories;

    /**
     * @var Collection<int, ProductAttribute>
     */
    #[ORM\OneToMany(targetEntity: ProductAttribute::class, mappedBy: 'productTemplate')]
    private Collection $productAttributes;

    public function __construct()
    {
        $this->productCategories = new ArrayCollection();
        $this->productAttributes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ProductCategory>
     */
    public function getProductCategories(): Collection
    {
        return $this->productCategories;
    }

    public function addProductCategory(ProductCategory $productCategory): static
    {
        if (!$this->productCategories->contains($productCategory)) {
            $this->productCategories->add($productCategory);
            $productCategory->setProductTemplate($this);
        }

        return $this;
    }

    public function removeProductCategory(ProductCategory $productCategory): static
    {
        if ($this->productCategories->removeElement($productCategory)) {
            // set the owning side to null (unless already changed)
            if ($productCategory->getProductTemplate() === $this) {
                $productCategory->setProductTemplate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductAttribute>
     */
    public function getProductAttributes(): Collection
    {
        return $this->productAttributes;
    }

    public function addProductAttribute(ProductAttribute $productAttribute): static
    {
        if (!$this->productAttributes->contains($productAttribute)) {
            $this->productAttributes->add($productAttribute);
            $productAttribute->setProductTemplate($this);
        }

        return $this;
    }

    public function removeProductAttribute(ProductAttribute $productAttribute): static
    {
        if ($this->productAttributes->removeElement($productAttribute)) {
            // set the owning side to null (unless already changed)
            if ($productAttribute->getProductTemplate() === $this) {
                $productAttribute->setProductTemplate(null);
            }
        }

        return $this;
    }
}
