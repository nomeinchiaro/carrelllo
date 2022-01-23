<?php

namespace App\Entity;

use App\Repository\ProductsInCartRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: ProductsInCartRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write', 'foo']],
)]
class ProductsInCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productsInCarts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["foo"])]
    private $product;

    #[ORM\ManyToOne(targetEntity: ShoppingCart::class, inversedBy: 'productsInCarts')]
    #[Groups(["write", "foo"])]
    private $cart;

    #[ORM\Column(type: 'integer')]
    #[Groups(["read", "foo"])]
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getCart(): ?ShoppingCart
    {
        return $this->cart;
    }

    public function setCart(?ShoppingCart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
