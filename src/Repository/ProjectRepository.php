<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use App\Entity\User;
use App\Entity\Team;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }


    // dql dor user list by project

    public function findByUserByProjectShow($id)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)

            ->innerJoin(
                Team::class, //Entity
                't', //alias
                Join::WITH, //join Type
                't.project =p.id' // Join columns
            )
            ->innerJoin(
                User::class, //Entity
                'u', //alias
                Join::WITH, //join Type
                'u.id =t.user' // Join columns
            )
            ->select('u.id', 'u.firstname', 'u.lastname')
            ->getQuery()
            ->getResult();
    }
    /*     // dql for lis all detail of project

        public function findByProjectD($id)
        {
            return $this->createQueryBuilder('p')
                    ->andWhere('p.id = :val')
                    ->setParameter('val', $id)

                    ->innerJoin(
                        Team::class, //Entity
                        't', //alias
                        Join::WITH, //join Type
                        't.project =p.id' // Join columns
                    )
                    ->innerJoin(
                        User::class, //Entity
                        'u', //alias
                        Join::WITH, //join Type
                        'u.id =t.user' // Join columns
                    )
                    ->select('p.id' ,'p.name','p.description','p.prod_link','p.git_link','p.picture','p.is_apotheose','p.youtube_link', 'u')
                    ->getQuery()
                    ->getResult();
        }
 */
        /**
         * 
        */
            //function pour recherche un utilisateur soit par le nom, prenom ou email
     public function findSearch($search)
     {  
      if (!empty($search)){
         $query= $this->createQueryBuilder('p')
             ->select('p')
                  ->Where('p.name LIKE :findproject')
                  ->setParameter('findproject', "%{$search}%"); 
                  return $query->getQuery()->getResult();
         }          
     } 


    
    // /**
    //  * @return Project[] Returns an array of Project objects
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
    public function findOneBySomeField($value): ?Project
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
