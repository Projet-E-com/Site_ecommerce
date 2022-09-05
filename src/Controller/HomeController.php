<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index( ProduitRepository $produit, CategorieRepository $categories): Response
    {
        return $this->render('home/index.html.twig', [
            'produit' => $produit->findAll(),
            'categories' => $categories->findAll()
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(CategorieRepository $categorie): Response
    {
        return $this->render('contact.html.twig', [
            'categories' => $categorie->findAll()
        ]);
    }

    #[Route('/apropos', name: 'app_apropos')]
    public function apropos(CategorieRepository $categorie): Response
    {
        return $this->render('apropos.html.twig', [
            'categories' => $categorie->findAll()
        ]);
    }
}
