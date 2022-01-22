<?php

namespace App\Repository;

use App\Entity\ProductsInCart;
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

    // /**
    //  * @return ProductsInCart[] Returns an array of ProductsInCart objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductsInCart
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
