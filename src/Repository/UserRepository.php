<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\User;
use App\Entity\Spe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function myFindall()
    {
        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = 'SELECT user.*, spe.name as speName FROM `user` INNER JOIN spe ON user.spe_id=spe.id ;';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
        // $qb = $this->createQueryBuilder('user')
        // ->select('user.id' ,'user.firstname','user.lastname','user.email','user.story','user.is_search_job','user.roles','user.picture', 's.name as speName')
        // ->join('u.spe', 's')
        // ->where('u.spe =spe.id');


        // return $qb->getQuery()->getResult();
    }

    //function pour supprimer tout les technos de l'user
    public function Deletedtechnouse(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = 'DELETE * FROM `techno_user` WHERE techno_user.userid= 202' ;

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
    }

    //function pour recherche un utilisateur soit par le nom, prenom ou email
     public function findSearch($search)
    {  
     if (!empty($search)){
        $query= $this->createQueryBuilder('u')
            ->select('u.id','u.firstname','u.lastname','u.email','u.story','u.is_search_job','u.roles','u.picture')
                 ->Where('u.email LIKE :finduser')
                 ->orWhere('u.lastname LIKE :finduser')
                 ->orWhere('u.firstname LIKE :finduser') 
                 ->setParameter('finduser', "%{$search}%"); 
                 return $query->getQuery()->getArrayResult();
        }          
    } 


    // function pour liste les technos de l'user

    // public function MytechnosList(int $id): ?User
    // {

    // $technolistid= $this->createQueryBuilder('u')
    // ->from ('t','techno_user')
    // ->select('t.technoid')
    // ->setParameter('id', $id)
    // ->where('t.userid= :id')
    // ->getQuery();

    // return $technolistid->getResult();
    // $em =$this->getDoctrine()->getManager();

    // $query='SELECT techno_user.techno as Technoid FROM `techno_user` where user_id= $id;';

    // $statement = $em->getConnection()->prepare($RAW_QUERY);
    // $statement->execute();

    // $technolistid = $statement->fetchAll();
    // return $technolistid;
    // }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
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
