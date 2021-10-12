<?php

namespace App\Repository;

use App\Entity\UrlApotheose;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UrlApotheose|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlApotheose|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlApotheose[]    findAll()
 * @method UrlApotheose[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlApotheoseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlApotheose::class);
    }


    /**
     * @return UrlApotheose[] Returns an array of UrlApotheose objects
     */
    
    public function findByApotheose($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.apotheose = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    // /**
    //  * @return UrlApotheose[] Returns an array of UrlApotheose objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UrlApotheose
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
