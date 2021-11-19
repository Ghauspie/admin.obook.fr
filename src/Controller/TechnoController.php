<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use App\Service\PictureService;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/techno")
 */
class TechnoController extends AbstractController
{
    /**
     * @Route("/", name="techno_index", methods={"GET"})
     */
    public function index(TechnoRepository $technoRepository): Response
    {
        return $this->render(
            'techno/index.html.twig', [
            'technos' => $technoRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="techno_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($techno);
            $entityManager->flush();
           
            return $this->redirectToRoute('techno_index');
        }
        
        return $this->renderForm(
            'techno/new.html.twig', [
            'techno' => $techno,
            'form' => $form,
            
            ]
        );
    }

    /**
     * @Route("/{id}", name="techno_show", methods={"GET"})
     */
    public function show(Techno $techno): Response
    {
        return $this->render(
            'techno/show.html.twig', [
            'techno' => $techno,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="techno_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Techno $techno): Response
    {
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $urllogo= $_FILES['techno']['name']['logo'];
            //old version qui récupère  le fichier renommer par wamp
            /* $urllogo=$data->getLogo(); */
            
            $entityManager=$this->getDoctrine()->getManager();
            $picture=[];
            $picture=(explode('\\',$urllogo));
            $urlpicture=array_pop($picture);
           
            //on vérifie que le fichier contient l'extension .png, ou .jpeg ou .svg
            if (strpos($urlpicture,".png")) {
                move_uploaded_file("https://obook.julien-vital.dev/upload/", $urlpicture);
                $techno->setLogo("https://obook.julien-vital.dev/upload/".$urlpicture);
                $entityManager->persist($techno);
                $entityManager->flush(); 
                return $this->redirectToRoute('techno_index', [], Response::HTTP_SEE_OTHER);
            }
            else {
                 $alertepicture= "LE format de l'image n'est pas correct veuillez postez une image au format .png, .SVG, .jpg";

                return $this->renderForm(
                    'techno/edit.html.twig', [
                    'techno' => $techno,
                    'form' => $form,
                    'alertepicture'=>$alertepicture,
                    ]
                );
            }
           

                        return $this->redirectToRoute('techno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'techno/edit.html.twig', [
            'techno' => $techno,
            'form' => $form,
            'alertepicture'=>"",
            ]
        );
    }

    /**
     * @Route("/{id}", name="techno_delete", methods={"POST"})
     */
    public function delete(Request $request, Techno $techno): Response
    {
        if ($this->isCsrfTokenValid('delete'.$techno->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($techno);
            $entityManager->flush();
        }

        return $this->redirectToRoute('techno_index', [], Response::HTTP_SEE_OTHER);
    }
}
