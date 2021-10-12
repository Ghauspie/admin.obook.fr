<?php

namespace App\Controller;

use App\Entity\Spe;
use App\Form\SpeType;
use App\Repository\SpeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spe")
 */
class SpeController extends AbstractController
{
    /**
     * @Route("/", name="spe_index", methods={"GET"})
     */
    public function index(SpeRepository $speRepository): Response
    {
        return $this->render(
            'spe/index.html.twig', [
            'spes' => $speRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="spe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $spe = new Spe();
        $form = $this->createForm(SpeType::class, $spe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($spe);
            $entityManager->flush();

            return $this->redirectToRoute('spe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'spe/new.html.twig', [
            'spe' => $spe,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="spe_show", methods={"GET"})
     */
    public function show(Spe $spe): Response
    {
        return $this->render(
            'spe/show.html.twig', [
            'spe' => $spe,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="spe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Spe $spe): Response
    {
        $form = $this->createForm(SpeType::class, $spe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'spe/edit.html.twig', [
            'spe' => $spe,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="spe_delete", methods={"POST"})
     */
    public function delete(Request $request, Spe $spe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($spe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spe_index', [], Response::HTTP_SEE_OTHER);
    }
}
