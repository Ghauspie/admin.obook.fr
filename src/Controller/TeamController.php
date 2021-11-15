<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TeamRepository;
use App\Entity\Team;
use App\Entity\User;
use App\Form\TeamType;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends AbstractController
{
    /**
     * @Route("/team", name="team")
     */
    public function index(TeamRepository $teamRepository): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $RAW_QUERY = 'select user.firstname as username,user.id as userId, user.lastname as lastname, project.id as project_id, 
        project.description as description, project.picture as picture, project.name as name, team.is_valid, team.id
        from team 
        INNER JOIN project ON project.id=team.project_id 
        INNER JOIN user ON team.user_id=user.id';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $result = $statement->fetchAll();
        return $this->render(
            'team/index.html.twig', [
            'Teams' =>  $result,
            ]
        );
    }

    /**
     * @Route("/team/{id}", name="team_delete", methods={"POST"})
     */
    public function delete(Request $request, Team $team, User $user): Response
    {
        // if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($team);
        $entityManager->flush();


        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/team/new", name="team_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('team', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'team/new.html.twig', [
            'team' => $team,
            'form' => $form,
            ]
        );
    }
}
