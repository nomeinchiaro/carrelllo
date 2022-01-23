<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ShoppingCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ORM\Entity(repositoryClass: ShoppingCartRepository::class)]
class ShoppingCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["write"])]
    private $id;

    #[ORM\Column(type: 'uuid', length: 32, unique: true)]
    #[Groups(["read", "write"])]
    private $uuid;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: ProductsInCart::class)]
    #[Groups(["read"])]
    #[MaxDepth(1)]
    private $productsInCarts;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->productsInCarts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection|ProductsInCart[]
     */
    public function getProductsInCarts(): Collection
    {
        return $this->productsInCarts;
    }

    public function addProductsInCart(ProductsInCart $productsInCart): self
    {
        if (!$this->productsInCarts->contains($productsInCart)) {
            $this->productsInCarts[] = $productsInCart;
            $productsInCart->setCart($this);
        }

        return $this;
    }

    public function removeProductsInCart(ProductsInCart $productsInCart): self
    {
        if ($this->productsInCarts->removeElement($productsInCart)) {
            // set the owning side to null (unless already changed)
            if ($productsInCart->getCart() === $this) {
                $productsInCart->setCart(null);
            }
        }

        return $this;
    }
}
