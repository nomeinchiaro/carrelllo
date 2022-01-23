<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductsInCart;
use App\Entity\ShoppingCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductsInCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsInCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsInCart[]    findAll()
 * @method ProductsInCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsInCartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductsInCart::class);
    }

    public function createItem(ProductsInCart $productInCart)
    {
        $this->getEntityManager()->persist($productInCart);
        $this->getEntityManager()->flush();
    }

    public function findByCartAndProduct(ShoppingCart $cart, Product $product): ?ProductsInCart
    {
        return $this->createQueryBuilder('item')
            ->andWhere('item.product = :product')
            ->andWhere('item.cart = :cart')
            ->setParameter('cart', $cart)
            ->setParameter('product', $product)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
