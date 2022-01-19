<?php

namespace App\Repository;

use App\Entity\CartOperations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CartOperations|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartOperations|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartOperations[]    findAll()
 * @method CartOperations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartOperationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartOperations::class);
    }

    // /**
    //  * @return CartOperations[] Returns an array of CartOperations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartOperations
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
