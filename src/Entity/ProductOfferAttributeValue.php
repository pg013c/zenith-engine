<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductOfferAttributeValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductOfferAttributeValueRepository::class)]
class ProductOfferAttributeValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productOfferAttributeValues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductOffer $productOffer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductAttribute $productAttribute = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductValue $productValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductOffer(): ?ProductOffer
    {
        return $this->productOffer;
    }

    public function setProductOffer(?ProductOffer $productOffer): static
    {
        $this->productOffer = $productOffer;

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

    public function getProductValue(): ?ProductValue
    {
        return $this->productValue;
    }

    public function setProductValue(?ProductValue $productValue): static
    {
        $this->productValue = $productValue;

        return $this;
    }
}
