<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Project;
use App\Entity\User;
use App\Form\AdduserType;
use App\Form\ProjectType;
use App\Form\SearchableEntityType;
use App\Form\SearchType;
use App\Repository\ProjectRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="project_index", methods={"GET"})
     */
    public function index(ProjectRepository $projectRepository, Request $request): Response
    {
        $data =new SearchData();
        $formSearch= $this->createForm(SearchType::class, $data);
        $formSearch->handleRequest($request);
        $Searchuser=$data->finduser;
        $projetlist=$projectRepository->findAll();
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }else{
            $currentPage = 1;
        }
        $countresult= count($projetlist);
        $numberpagedisplay= $countresult/10; // on recupere le resultat 
        $numberpagedisplay=($numberpagedisplay%5)+1;// ici on fait un modulo de 5 du resultat pour obtenir un chiffre pile de plus on rajouter 1 pour eviter de perdre des profils    
        if($currentPage==1){
            $numberusernim=0;
 /*            $numberusermax=10;    */ 
            }
        else{
            $numberusernim=(10*$currentPage)-10;
/*             $numberusermax=(10*$paginationuser)+10; */
        }

        // si on a fait une recherche d'utilisateur
        if (!empty($Searchuser)){
            $result=$projectRepository->findSearch($Searchuser);
            
            $isSearchProjet=1;
                return $this->render(
                    'project/index.html.twig', [
                    'projects' => $result,
                    'countresult'=> $numberpagedisplay,
                    'numberusernim'=>$numberusernim,
                    'form'=>$formSearch->createView(),
                    'isSearchProjet'=> $isSearchProjet
                    ]
                );
            };
     
            
    
        return $this->render(
            'project/index.html.twig', [
            'projects' => $projetlist,
            'countresult'=> $numberpagedisplay,
            'numberusernim'=>$numberusernim,
            'form'=>$formSearch->createView(),
            ]
        );
    }

    /**
     * @Route("/new", name="project_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'project/new.html.twig', [
            'project' => $project,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="project_show", methods={"GET"})
     */
    public function show(Project $project, ProjectRepository $projectRepo, $id): Response
    {
        $users=[];
        $users=$projectRepo->findByUserByProjectShow($id);
        return $this->render(
            'project/show.html.twig', [
            'project' => $project,
            'users'=>$users
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="project_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Project $project, UserRepository $userRepo, $id): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="project_delete", methods={"POST"})
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
    }


    /*     /**
         * @Route("/{id}/adduser", name="user_add", methods={"GET","POST"} )
         */
    /*     public function adduserfromproject(Request $request, UserRepository $userRepo,Project $project): Response
    {
        $users=$userRepo->findall();
        $form = $this->createForm(AdduserType::class, $project);
        $form->handleRequest($request);  */

    /*         if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_index', [], Response::HTTP_SEE_OTHER);
        } */

    /*         return $this->renderForm('project/adduser.html.twig', [
            'listuser' => $users,
            'project' => $project,
        ]);
    }  */
}
