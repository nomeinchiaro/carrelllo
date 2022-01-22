<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ShoppingCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShoppingCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCart[]    findAll()
 * @method ShoppingCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingCart::class);
    }
    
    public function createCart(ShoppingCart $cart)
    {
        $this->getEntityManager()->persist($cart);
        $this->getEntityManager()->flush();
    }

    public function addProductToCart(ShoppingCart $cart, Product $product)
    {
        // $cart->addProduct($product);
        // $product->addCart($cart);
        // $this->getEntityManager()->persist($cart);
        // $this->getEntityManager()->persist($cart);
        // $this->getEntityManager()->flush();
    }
}
