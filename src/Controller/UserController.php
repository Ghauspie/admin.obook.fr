<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\User;
use App\Form\SearchType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\SpeRepository;
use App\Repository\TechnoRepository;
use App\Repository\ContratRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{


    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
     
        $data =new SearchData();
        $formSearch= $this->createForm(SearchType::class, $data);
        $formSearch->handleRequest($request);
        $Searchuser=$data->finduser;
        // si on a fait une recherche d'utilisateur
        if (!empty($Searchuser)){
            $result=$userRepository->findSearch($Searchuser);
            
            //partie paginations 
            if(isset($_GET['page']) && !empty($_GET['page'])){
                $currentPage = (int) strip_tags($_GET['page']);
            }else{
                $currentPage = 1;
            }

            $countresult= count($result);
            $numberpagedisplay= $countresult/10; // on recupere le resultat 
            $numberpagedisplay=($numberpagedisplay%5)+1;// ici on fait un modulo de 5 du resultat pour obtenir un chiffre pile, de plus on rajouter 1 pour eviter de perdre des profils
            if($currentPage==1){
                $numberusernim=0;

                }
            else{
                $numberusernim=(10*$currentPage)-10;
            }
            $isSearchUser=1;
                return $this->render(
                    'user/index.html.twig', [
                    'users' => $result,
                    'countresult'=> $numberpagedisplay,
                    'numberusernim'=>$numberusernim,
                    'form'=>$formSearch->createView(),
                    'isSearchUser'=> $isSearchUser
                    ]
                );
            }
        // par defaut on affiche tout les utilisateur avec une jointure pour avoir les nom des spe
        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = 'SELECT user.*, spe.name as speName FROM `user` INNER JOIN spe ON user.spe_id=spe.id order by user.id ;';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $result = $statement->fetchAll();
        //partie paginations 
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }else{
            $currentPage = 1;
        }

        $countresult= count($result);
        $numberpagedisplay= $countresult/10; // on recupere le resultat 
        $numberpagedisplay=($numberpagedisplay%5)+1;// ici on fait un modulo de 5 du resultat pour obtenir un chiffre pile de plus on rajouter 1 pour eviter de perdre des profils
        if($currentPage==1){
            $numberusernim=0;

            }
        else{
            $numberusernim=(10*$currentPage)-10;
        }
        $isSearchUser=0;
       
        return $this->render(
            'user/index.html.twig', [
            'users' => $result,
            'countresult'=> $numberpagedisplay,
            'numberusernim'=>$numberusernim,
            'form'=>$formSearch->createView(),
            'isSearchUser'=> $isSearchUser
            ]
        );
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(SerializerInterface $serializer, Request $request, SpeRepository $speRepo,UserPasswordEncoderInterface $encoder, TechnoRepository $technoRepo, ContratRepository $contratRepo): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);    
        // $spe_id=$user->getSpeId();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data =$form->getData();
            $params= $request->request->all();
             //on recupere l'infos du roles et on le serialize pour etre au format json afin de pouvoir faire le set
             $requestrole=$params['user']['roles'];
             if ($requestrole == '1') {
                 $role=array('ROLE_ADMIN');
                 $user->setRoles1($role);
             }
             else {
                 $role =array('ROLE_USER');
                 $user->setRoles1($role);
             };
/*              $jsonrole= $serializer->serialize($userol,'json');
                     
             $roleu=json_decode($jsonrole); */

            $pass=$data->getPassword();
            // Récupération des data technos dans la request
            $datatechno=$data->getTechnos();
            $datacontrat=$data->getContrats();

            // $spe=$user->getSpeList($data);
            // $speId=$spe[0]['id'];
            // $spe=$user.spe_id;
            // $user->setSpeId($spe);
            $user->setPassword($encoder->encodePassword($user, $pass));
            /* $user->setRoles($roleu); */ 
            $entityManager->persist($user);
            if (!empty($datatechno)) {
                $technousers=[];
                foreach ($datatechno as $techno) {
                    $techno = $technoRepo->find($techno);
                    if (empty($techno)) {
                        return $this->json('techno not found', 404);
                    }
                    $techno->addUser($user);
                    $entityManager->persist($techno);
                    $technousers[]=$techno;
                }
            }
            if (!empty($datacontrat)) {
                $contratusers=[];
                foreach ($datacontrat as $contrat) {
                    $contrat = $contratRepo->find($contrat);
                    if (empty($contrat)) {
                        return $this->json('techno not found', 404);
                    }
                    $contrat->addUser($user);
                    $entityManager->persist($contrat);
                    $contratusers[]=$contrat;
                }
            }
            $entityManager->flush();

            // return $this->renderForm('user/test.html.twig', [
            // 'userrequest' => $user,
            // 'spe'=>$technousers,
            // ]);
                return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'user/new.html.twig', [
            'user' => $user,
            'form' => $form,

            ]
        );
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(UserRepository $userRepo, SpeRepository $speRepo, TechnoRepository $technoRepo, $id): Response
    {
        // avoir le nom de la spe
        // $repository = $this->getDoctrine()
        // ->getManager()
        // ->getRepository('App:Spe');
        $user=$userRepo->find($id);

        $speid=$user->getSpeList();
        // $spe=$repository->find($spe_id);
        // $spename=$spe->getName();

        $technos=$user->getTechno();
        $contrats=$user->getContrat();
        return $this->render(
            'user/show.html.twig', [
            'user' => $user,
            'spe'=>$speid,
            'technos'=> $technos,
            'contrats'=>$contrats,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user,SerializerInterface $serializer, UserRepository $userRepo, SpeRepository $speRepo,UserPasswordEncoderInterface $encoder, TechnoRepository $technoRepo, ContratRepository $contratRepo, $id): Response
    {
        //creation du formulaire d'edition d'un utilisateur
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        // On récupere les infos de technos de l'user
        $technodel=$user->getTechnos();

        $dataR=$request->getContent();

        // on récupére les données présent dans le form
        $data =$form->getData();
        // On récupere les infos de technos de l'user
        $datatechno=$data->getTechnos();
        // On récupere les infos de contrat de l'user
        $datacontrat=$data->getContrats();
        // On récupere les infos de roles de l'user

        $roleusers=$data->getRoles();
        /*         $roles=[];
        foreach ($roleusers as $role) {
            $role=$role;
            $roles[]=$role;
        }  ; */
     
        // $test= $userRepo->MytechnosList($id);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager =$this->getDoctrine()->getManager();
            //on recuperer les contenus de request
            $params= $request->request->all();
            $requestuser=$params;
            $requestrole=$requestuser['user']['roles'];
            if ($requestrole == '1') {
                $role=array('ROLE_ADMIN');
                $user->setRoles1($role);
            }
            else {
                $role =array('ROLE_USER');
                $user->setRoles1($role);
            };
            $data =$form->getData();
            
            $datatechno=$data->getTechnos();

            $datacontrat=$data->getContrats();      

            $user->setFirstname($data->getFirstname());
            $user->setLastname($data->getLastname());
            $user->setEmail($data->getEmail());
            $user->setStory($data->getStory());
            $user->setIsSearchJob($data->getIsSearchJob());
            $user->setPicture($data->getPicture());
            $user->setPassword($encoder->encodePassword($user, $data->getPassword()));

            $entityManager->persist($user);
            /*             $RoleUser=[];
             foreach ($roleusers as $role) {
                $user->setRoles($role);
                $RoleUser[]=$role;
                $entityManager->persist($role);
            }   */
            
            $entityManager->persist($user);

            // on verifie que datatechno n'est pas null
            if (!empty($datatechno)) {
                // Suprresion des technos pour l'update
                $Technoall=$technoRepo->findall();
                foreach ($Technoall as $technodel) {
                    $technodel->removeUser($user);
                }
                // on ajoute l'edition des technos
                $technousers=[];
                foreach ($datatechno as $techno) {
                    $techno = $technoRepo->find($techno);
                    if (empty($techno)) {
                        return $this->json('techno not found', 404);
                    }

                    $techno->addUser($user);
                    $entityManager->persist($techno);
                    $technousers[]=$techno;
                }
            }
            if (!empty($datacontrat)) {
                // Suprresion des technos pour l'update
                $contratall=$contratRepo->findall();
                foreach ($contratall as $contratdel) {
                    $contratdel->removeUser($user);
                }
                $contratusers=[];
                foreach ($datacontrat as $contrat) {
                    $contrat = $contratRepo->find($contrat);
                    if (empty($contrat)) {
                        return $this->json('techno not found', 404);
                    }
                    $contrat->addUser($user);
                    $entityManager->persist($contrat);
                    $contratusers[]=$contrat;
                }
            }

        
            $entityManager->persist($user);
            $entityManager->flush(); 
         
            // return $this->renderForm('user/test.html.twig', [
             // 'userrequest' => $role,
             // 'spe'=>$contratall,
             // ])
             // ;
             
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'roleusers' => $request,
            ]
        );
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }



}
