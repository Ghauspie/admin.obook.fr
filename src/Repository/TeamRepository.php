<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    // /**
    //  * @return Team[] Returns an array of Team objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /*
    // Ici on créer le DQL permettant de liste tout les projets avec par projet son nom, sa decription, l'image du projet et la liste de tout les utilisateur du projet
    */
    public function findTeamAll()
    {
        return $this->getEntityManager()
            ->createQuery(
                'select user.firstname as username, user.lastname as lastname, project.id as project_id, 
            project.description as description, project.picture as picture, project.name as name, team.isvalid 
            from team 
            INNER JOIN project ON project.id=team.project_id 
            INNER JOIN user ON team.user_id=user.id
            '
            )
            ->getResult();
    }
    public function findbyproject()
    {
        return $this->getEntityManager()
            ->createQuery(
                'select project.id as project_id, project.description as description, project.picture as picture, project.name as name, team.is_valid as is_valid from team INNER JOIN project ON team.project_id=project.id 
            GROUP BY team.project_id'
            )
            ->getResult();
    }

    public function finduserbyproject($projectid)
    {
        return $this->getEntityManager($projectid)
            ->createQuery('select team.*, user.id as user_id, user.lastname as lastname, user.firstname as firstname from team INNER JOIN user ON team.user_id=user.id where project_id =$projectid')
            ->getResult();
    }
}
