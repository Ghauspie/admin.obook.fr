<?php

namespace App\Controller;


use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $textmessage=$contactFormData['message'];
            $emailcontact=$contactFormData['email'];
            $email = (new Email())
                ->from('admin@obook.fr')
                ->to($emailcontact)
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Alerte Obook')
                ->text('Le serveur obook a besoin de vous')
                ->html(
                    '<html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Alerte obook</title>
                    <style>
                    h1 {
                        text-align: left;
                        color: red;
                    }
                    </style>
                </head>
                <body>
                
                <a href="https://zupimages.net/viewer.php?id=21/33/8pc6.png"><img src="https://zupimages.net/up/21/33/8pc6.png" alt="Obook logo" /></a>
                <h1> Obook monitoring alerte</h1></br>
                <p>Un probleme à été detecté sur le serveur ou la bdd</p></br>
                <p>'.$textmessage.'</p>
                </body>
                </html>'
                );

                $mailer->send($email);

            return $this->redirectToRoute('contact');

        }
        return $this->render(
            'contact/index.html.twig', [
                'form' => $form->createView()
            ]
        );
    }


    ///**
    // * @Route("/contact/sendmail", name="contact_sendmail")
     //*/
    /* public function sendmail($contactFormData, MailerInterface $mailer)
    {
        $message = (new Email())
            ->from($contactFormData['email'])
            ->to('hauspie.guillaume@free.fr')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Alerte Obook')
            ->text('Le serveur obook a besoin de vous')
            ->html('<h1> Obook monitoring alerte</h1></br>
            <p>Un probleme à était detecté sur le serveur ou la bdd</p></br>
            <p>'.$contactFormData['Message'].'</p>');

        $mailer->send($message);
        $this->addFlash('success', 'Vore message a été envoyé');
        return $this->redirectToRoute('main');
    } */
}
