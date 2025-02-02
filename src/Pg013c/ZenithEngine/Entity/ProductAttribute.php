<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Pg013c\ZenithEngine\Repository\ProductAttributeRepository;

#[ORM\Entity(repositoryClass: ProductAttributeRepository::class)]
class ProductAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    /**
     * @var Collection<int, ProductValue>
     */
    #[ORM\OneToMany(targetEntity: ProductValue::class, mappedBy: 'productAttribute')]
    private Collection $productValues;

    #[ORM\ManyToOne(inversedBy: 'productAttributes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductTemplate $productTemplate = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childProductAttributes')]
    private ?self $parentProductAttribute = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parentProductAttribute')]
    private Collection $childProductAttributes;

    #[ORM\Column(nullable: true)]
    private ?int $importId = null;

    #[ORM\Column(nullable: true)]
    private ?int $parentImportId = null;

    #[ORM\Column]
    private ?bool $isRequired = null;

    public function __construct()
    {
        $this->productValues = new ArrayCollection();
        $this->childProductAttributes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, ProductValue>
     */
    public function getProductValues(): Collection
    {
        return $this->productValues;
    }

    public function addProductValue(ProductValue $productValue): static
    {
        if (!$this->productValues->contains($productValue)) {
            $this->productValues->add($productValue);
            $productValue->setProductAttribute($this);
        }

        return $this;
    }

    public function removeProductValue(ProductValue $productValue): static
    {
        if ($this->productValues->removeElement($productValue)) {
            // set the owning side to null (unless already changed)
            if ($productValue->getProductAttribute() === $this) {
                $productValue->setProductAttribute(null);
            }
        }

        return $this;
    }

    public function getProductTemplate(): ?ProductTemplate
    {
        return $this->productTemplate;
    }

    public function setProductTemplate(?ProductTemplate $productTemplate): static
    {
        $this->productTemplate = $productTemplate;

        return $this;
    }

    public function getParentProductAttribute(): ?self
    {
        return $this->parentProductAttribute;
    }

    public function setParentProductAttribute(?self $parentProductAttribute): static
    {
        $this->parentProductAttribute = $parentProductAttribute;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildProductAttributes(): Collection
    {
        return $this->childProductAttributes;
    }

    public function addChildProductAttribute(self $childProductAttribute): static
    {
        if (!$this->childProductAttributes->contains($childProductAttribute)) {
            $this->childProductAttributes->add($childProductAttribute);
            $childProductAttribute->setParentProductAttribute($this);
        }

        return $this;
    }

    public function removeChildProductAttribute(self $childProductAttribute): static
    {
        if ($this->childProductAttributes->removeElement($childProductAttribute)) {
            // set the owning side to null (unless already changed)
            if ($childProductAttribute->getParentProductAttribute() === $this) {
                $childProductAttribute->setParentProductAttribute(null);
            }
        }

        return $this;
    }

    public function getImportId(): ?int
    {
        return $this->importId;
    }

    public function setImportId(?int $importId): static
    {
        $this->importId = $importId;

        return $this;
    }

    public function getParentImportId(): ?int
    {
        return $this->parentImportId;
    }

    public function setParentImportId(?int $parentImportId): static
    {
        $this->parentImportId = $parentImportId;

        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setRequired(bool $isRequired): static
    {
        $this->isRequired = $isRequired;

        return $this;
    }
}
