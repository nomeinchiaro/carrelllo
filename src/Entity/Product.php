<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write', 'foo']],
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'uuid', length: 32, unique: true)]
    #[Groups(["read", "write"])]
    private $uuid;

    #[ORM\Column(type: 'string', length: 10, unique: true)]
    #[Groups(["read", "foo"])]
    private $sku;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductsInCart::class)]
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
            $productsInCart->setProduct($this);
        }

        return $this;
    }

    public function removeProductsInCart(ProductsInCart $productsInCart): self
    {
        if ($this->productsInCarts->removeElement($productsInCart)) {
            // set the owning side to null (unless already changed)
            if ($productsInCart->getProduct() === $this) {
                $productsInCart->setProduct(null);
            }
        }

        return $this;
    }
}
