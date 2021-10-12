<?php

namespace App\Controller;

use App\Entity\UrlApotheose;
use App\Form\UrlApotheoseType;
use App\Repository\UrlApotheoseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlApotheoseController extends AbstractController
{
    /**
     * @Route("/url/apotheose", name="url_apotheose_index", methods={"GET"})
     */
    public function index(UrlApotheoseRepository $urlApotheoseRepository): Response
    {
        return $this->render(
            'url_apotheose/index.html.twig', [
            'url_apotheoses' => $urlApotheoseRepository->findAll(),
            ]
        );
    }



    /**
     * @Route("/url/apotheose/new", name="url_apotheose_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $urlApotheose = new UrlApotheose();
        $form = $this->createForm(UrlApotheoseType::class, $urlApotheose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($urlApotheose);
            $entityManager->flush();

            return $this->redirectToRoute('url_apotheose_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'url_apotheose/new.html.twig', [
            'url_apotheose' => $urlApotheose,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/url/apotheose/{id}", name="url_apotheose_show", methods={"GET"})
     */
    public function show(UrlApotheose $urlApotheose): Response
    {
        return $this->render(
            'url_apotheose/show.html.twig', [
            'url_apotheose' => $urlApotheose,
            ]
        );
    }

    /**
     * @Route("/url/apotheose/{id}/edit", name="url_apotheose_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UrlApotheose $urlApotheose): Response
    {
        $form = $this->createForm(UrlApotheose1Type::class, $urlApotheose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('url_apotheose_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'url_apotheose/edit.html.twig', [
            'url_apotheose' => $urlApotheose,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/url/apotheose/{id}", name="url_apotheose_delete", methods={"POST"})
     */
    public function delete(Request $request, UrlApotheose $urlApotheose): Response
    {
        if ($this->isCsrfTokenValid('delete'.$urlApotheose->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($urlApotheose);
            $entityManager->flush();
        }

        return $this->redirectToRoute('url_apotheose_index', [], Response::HTTP_SEE_OTHER);
    }
}
