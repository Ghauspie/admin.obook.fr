<?php

namespace App\Controller;

use App\Entity\Apotheose;
use App\Form\ApotheoseType;
use App\Repository\ApotheoseRepository;
use App\Repository\UrlApotheoseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apotheose")
 */
class ApotheoseController extends AbstractController
{
    /**
     * @Route("/", name="apotheose_index", methods={"GET"})
     */
    public function index(ApotheoseRepository $apotheoseRepository): Response
    {
        return $this->render(
            'apotheose/index.html.twig', [
            'apotheoses' => $apotheoseRepository->findAll(),
            ]
        );
    }

        /**
         * @Route("/new", name="apotheose_new", methods={"GET","POST"})
         */
    public function new(Request $request, UrlApotheoseRepository $UrlApoRepo): Response
    {
        $apotheose = new Apotheose();
        $form = $this->createForm(ApotheoseType::class, $apotheose);
        $form->handleRequest($request);
        dump($apotheose);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $urls=$data->getUrlapotheose();
            dump($urls);
            $entityManager = $this->getDoctrine()->getManager();
            $promo=$data->getPromo();
            $description=$data->getDescription();
            $apotheose->setPromo($promo);
            $apotheose->setDescription($description);
            $entityManager->persist($apotheose);
            $urlapotheoses=[];
            foreach ($urls as $url) {
                   $urlid=$url->getid(); 
                   $url = $UrlApoRepo->find($urlid); 
                $url->setApotheose($apotheose);
                $entityManager->persist($url);
                $urlapotheoses[]=$url;
            }  
            $entityManager->flush();
        
            dump($urlapotheoses);

            return $this->redirectToRoute('apotheose_index', [], Response::HTTP_SEE_OTHER);  
        }  

        return $this->renderForm(
            'apotheose/new.html.twig', [
            'apotheose' => $apotheose,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="apotheose_show", methods={"GET"})
     */
    public function show(Apotheose $apotheose, UrlApotheoseRepository $urlApoRepo): Response
    {
        $urls=$urlApoRepo->findByApotheose($apotheose);
        dump($urls);
        return $this->render(
            'apotheose/show.html.twig', [
            'apotheose' => $apotheose,
            'urllist'=>$urls,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="apotheose_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Apotheose $apotheose,UrlApotheoseRepository $urlRepo, $id): Response
    {
        $form = $this->createForm(ApotheoseType::class, $apotheose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $urls=$data->getUrlapotheose();
            dump($id);
            $entityManager = $this->getDoctrine()->getManager();
            $promo=$data->getPromo();
            $description=$data->getDescription();
            $apotheose->setPromo($promo);
            $apotheose->setDescription($description);
            $entityManager->persist($apotheose);
            $urlapotheoses=[];
            if (!empty($urls) ) {
                $urlRepoApo=$urlRepo->findByApotheose($id);
                //modification des champ de la table urlapothéose a null pour supprimer l'apothéose.
                $cleanUrlApo=[];
                foreach ($urlRepoApo as $url) {
                    $urlid=$url->getid(); 
                    $url = $urlRepo->find($urlid); 
                    $url->setApotheose(null);
                    $entityManager->persist($url);
                    $cleanUrlApo[]=$url;
                }
                $urlapotheoses=[];
                //Puis il pousse les modifications
                foreach ($urls as $url) {
                    $urlid=$url->getid(); 
                    $url = $urlRepo->find($urlid); 
                    $url->setApotheose($apotheose);
                    $entityManager->persist($url);
                    $urlapotheoses[]=$url;
                };  
            }
            //sinon il les pousse sans faire de modif
            foreach ($urls as $url) {
                $urlid=$url->getid(); 
                $url = $urlRepo->find($urlid); 
                $url->setApotheose($apotheose);
                $entityManager->persist($url);
                $urlapotheoses[]=$url;
            }  
            $entityManager->flush();
        
            dump($urlapotheoses);

            return $this->redirectToRoute('apotheose_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'apotheose/edit.html.twig', [
            'apotheose' => $apotheose,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="apotheose_delete", methods={"POST"})
     */
    public function delete(Request $request, Apotheose $apotheose,UrlApotheoseRepository $urlRepo, $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apotheose->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            //Recupération de l'id de l'apothéose
            $idApotheose=$apotheose->getId();
           
            // Recherche des url lier a cette apothéose
            $urls=$urlRepo->findByApotheose($idApotheose);
            //modification des champ de la table urlapothéose a null pour supprimer l'apothéose.
            $urlapotheoses=[];
            foreach ($urls as $url) {
                   $urlid=$url->getid(); 
                   $url = $urlRepo->find($urlid); 
                $url->setApotheose(null);
                $entityManager->persist($url);
                $urlapotheoses[]=$url;
            }  
            $entityManager->remove($apotheose);
            $entityManager->flush();
        }

        return $this->redirectToRoute('apotheose_index', [], Response::HTTP_SEE_OTHER);
    }
}
