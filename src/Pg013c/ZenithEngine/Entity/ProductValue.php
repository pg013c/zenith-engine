<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Pg013c\ZenithEngine\Repository\ProductValueRepository;

#[ORM\Entity(repositoryClass: ProductValueRepository::class)]
class ProductValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'productValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductAttribute $productAttribute = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childProductValues')]
    private ?self $parentProductValue = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parentProductValue')]
    private Collection $childProductValues;

    #[ORM\Column(nullable: true)]
    private ?int $importId = null;

    #[ORM\Column(nullable: true)]
    private ?int $parentImportId = null;

    public function __construct()
    {
        $this->childProductValues = new ArrayCollection();
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

    public function getProductAttribute(): ?ProductAttribute
    {
        return $this->productAttribute;
    }

    public function setProductAttribute(?ProductAttribute $productAttribute): static
    {
        $this->productAttribute = $productAttribute;

        return $this;
    }

    public function getParentProductValue(): ?self
    {
        return $this->parentProductValue;
    }

    public function setParentProductValue(?self $parentProductValue): static
    {
        $this->parentProductValue = $parentProductValue;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildProductValues(): Collection
    {
        return $this->childProductValues;
    }

    public function addChildProductValue(self $childProductValue): static
    {
        if (!$this->childProductValues->contains($childProductValue)) {
            $this->childProductValues->add($childProductValue);
            $childProductValue->setParentProductValue($this);
        }

        return $this;
    }

    public function removeChildProductValue(self $childProductValue): static
    {
        if ($this->childProductValues->removeElement($childProductValue)) {
            // set the owning side to null (unless already changed)
            if ($childProductValue->getParentProductValue() === $this) {
                $childProductValue->setParentProductValue(null);
            }
        }

        return $this;
    }

    public function getImportId(): ?int
    {
        return $this->importId;
    }

    public function setImportId(int $importId): static
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
}
