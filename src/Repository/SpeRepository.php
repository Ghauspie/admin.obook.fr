<?php

namespace App\Repository;

use App\Entity\Spe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Spe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spe[]    findAll()
 * @method Spe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spe::class);
    }

    // /**
    //  * @return Spe[] Returns an array of Spe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Spe
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
