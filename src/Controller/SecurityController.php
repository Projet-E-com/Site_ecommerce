<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, CategorieRepository $categorie): Response
    {

//       if ($this->getUser()) {
//
////           $sms = new SmsMessage(
////           // the phone number to send the SMS message to
////               '+2250788146470',
////               // the message
////               'Nouvelle connexion a ton compte. whouuuuuu sa marche !!!!!!!',
////               // optionally, you can override default "from" defined in transports
////               '+2250779501388',
////           );
////
////           $sentMessage = $texter->send($sms);
//
//           return $this->redirectToRoute('app_home');
//
//       }

       // get the login error if there is one
       $error = $authenticationUtils->getLastAuthenticationError();
       // last username entered by the user
       $lastUsername = $authenticationUtils->getLastUsername();

       return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'categories' => $categorie->findAll(),]);

    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
