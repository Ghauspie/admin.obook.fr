<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */

    public function login(AuthenticationUtils $authenticationUtils, UserRepository $UserRepo): Response

    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index_obook');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
      

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername,'error' => $error]);

    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        session_destroy();
        return $this->render('security/login.html.twig');
    }

}
