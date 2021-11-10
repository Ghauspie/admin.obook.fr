<?php

namespace App\DataFixtures;

use App\Entity\Contrat;
use App\Entity\Project;
use App\Entity\Spe;
use App\Entity\Team;
use App\Entity\Techno;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FixtureObook extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, /* PictureService $pictureService */)
    {
        $this->passwordEncoder = $passwordEncoder;
        /* $this->pictureService = $pictureService; */
    }

    public function load(ObjectManager $manager)
    {
        $faker= \Faker\Factory::create('fr_FR');

        //---------------------------------------
        //######## SPE
        //---------------------------------------
        $spes=[];
        $spe= new Spe();
        $spe->setName("Fullstack");
        $spes[]=$spe;
        $manager->persist(($spe));


        $spe= new Spe();
        $spe->setName("Front-end");
        $spes[]=$spe;
        $manager->persist(($spe));


        $spe= new Spe();
        $spe->setName("Back-end");
        $spes[]=$spe;
        $manager->persist(($spe));


        //---------------------------------------
        //######## Contrat
        //---------------------------------------
        
        $contrats=[];
        $contrat= new Contrat();
        $contrat->setName("CDI");
        $contrats[]=$contrat;
        $manager->persist(($contrat));

        $contrat= new Contrat();
        $contrat->setName("CDD");
        $contrats[]=$contrat;
        $manager->persist(($contrat));

        $contrat= new Contrat();
        $contrat->setName("Intérim");
        $contrats[]=$contrat;
        $manager->persist(($contrat));

        $contrat= new Contrat();
        $contrat->setName("Stage");
        $contrats[]=$contrat;
        $manager->persist(($contrat));

        


        //---------------------------------------
        //######## TECHNO
        //---------------------------------------

        $technos=[];
        $techno= new Techno();
        $techno->setName("Java");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("React");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("PHP");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("Symfony");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("Wordpress");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("Prestashop");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("Oracle");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("Powershell");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("C#");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        $techno= new Techno();
        $techno->setName("Python");
        $techno->setIsValid(rand(0, 1));
        $technos[]=$techno;
        $manager->persist(($techno));

        //---------------------------------------
        //######## USER
        //---------------------------------------
        $users = [];
        for ($i =0;$i<20;$i++) {
            $userSpe = $spes[rand(0, count($spes) - 1)];
            $usercontrat=$contrats[rand(0, count($contrats)-1)];
            $userTechno=$technos[rand(0, count($technos)-1)];

            $user= new User;
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($faker->email());
            $user->setIsSearchJob(rand(0, 1));
            $user->setStory($faker->realText($maxNbChars = 200, $indexSize = 2));
            $user->setPassword($this->passwordEncoder->encodePassword($user, "Testobook"));
            $user->setSpe($userSpe);
            $user->addTechno($userTechno);
            $user->addContrat($usercontrat);
            $user->setPicture($this->pictureService->generateUser());
            $manager->persist($user);
            $users[]=$user;
        }

        //---------------------------------------
        //######## PROJECT
        //---------------------------------------
        $projects=[];
        for ($i = 0; $i<10; $i++) {
            $project = new Project();
            $project->setName("Project ".$i)
                ->setDescription($faker->text($maxNbChars = 400));
            if (rand(0, 1)) {
                $project->setprodLink("www.link-prod-projet-$i.com");
            }
            if (rand(0, 1)) {
                $project->setgitLink("www.link-git-projet-$i.com");
            }
            if (rand(0, 1)) {
                $project->setYoutubeLink("www.link-youtube-projet-$i.com");
            }
            $project->setPicture('https://picsum.photos/300')
            ->setIsApotheose(rand(0, 1));
            $projects[]=$project;
            $manager->persist($project);
        }


        //---------------------------------------
        //######## TEAM
        //---------------------------------------
        for ($i = 0; $i < 20; $i++) {
            $team = new Team();
            $teamProject = $projects[rand(0, count($projects) - 1)];
            $teamUser = $users[rand(0, count($users) - 1)];

            $team->setProject($teamProject);
            $team->setUser($teamUser);
            $team->setIsValid(rand(0, 1));
 
            $manager->persist($team);
        }

        $manager->flush();
    }
}
