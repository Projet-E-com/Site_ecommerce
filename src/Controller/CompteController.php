<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route('/compte', name: 'app_compte')]
    public function index(): Response
    {
        return $this->render('compte/index.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }

    #[Route('/souhait', name: 'app_souhait')]
    public function souhait(): Response
    {
        return $this->render('compte/souhait.html.twig');
    }

    #[Route('/panier', name: 'app_panier')]
    public function panier(): Response
    {
        return $this->render('compte/panier.html.twig');
    }
}
