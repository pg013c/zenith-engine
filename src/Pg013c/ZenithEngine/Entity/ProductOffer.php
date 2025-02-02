<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Pg013c\ZenithEngine\Repository\ProductOfferRepository;

#[ORM\Entity(repositoryClass: ProductOfferRepository::class)]
class ProductOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, ProductOfferAttributeValue>
     */
    #[ORM\OneToMany(targetEntity: ProductOfferAttributeValue::class, mappedBy: 'productOffer')]
    private Collection $productOfferAttributeValues;

    public function __construct()
    {
        $this->productOfferAttributeValues = new ArrayCollection();
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
     * @return Collection<int, ProductOfferAttributeValue>
     */
    public function getProductOfferAttributeValues(): Collection
    {
        return $this->productOfferAttributeValues;
    }

    public function addProductOfferAttributeValue(ProductOfferAttributeValue $productOfferAttributeValue): static
    {
        if (!$this->productOfferAttributeValues->contains($productOfferAttributeValue)) {
            $this->productOfferAttributeValues->add($productOfferAttributeValue);
            $productOfferAttributeValue->setProductOffer($this);
        }

        return $this;
    }

    public function removeProductOfferAttributeValue(ProductOfferAttributeValue $productOfferAttributeValue): static
    {
        if ($this->productOfferAttributeValues->removeElement($productOfferAttributeValue)) {
            // set the owning side to null (unless already changed)
            if ($productOfferAttributeValue->getProductOffer() === $this) {
                $productOfferAttributeValue->setProductOffer(null);
            }
        }

        return $this;
    }
}
