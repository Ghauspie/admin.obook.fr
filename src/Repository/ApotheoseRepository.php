<?php

namespace App\Repository;

use App\Entity\Apotheose;
use App\Entity\UrlApotheose;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apotheose|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apotheose|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apotheose[]    findAll()
 * @method Apotheose[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApotheoseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apotheose::class);
    }

    /**
     * 
     */
    public function findByExampleField($id)
    {
        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = 'SELECT urlapotheose FROM urlapotheose WHERE urlapotheose.apotheoseid= 2';

         $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        return $statement;
    }

    // /**
    //  * @return Apotheose[] Returns an array of Apotheose objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Apotheose
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
