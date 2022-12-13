<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index( ProduitRepository $produit, CategorieRepository $categories, PanierRepository $paniers, ?Panier $panier, ?Produit $produits): Response
    {
        return $this->render('home/index.html.twig', [
            'produits' => $produit->findAll(),
            'categories' => $categories->findAll(),
            'paniers' => $paniers->findBy(array('user'=>$this->getUser())),
            'panier' => $panier,
            'produit' => $produits
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(CategorieRepository $categorie, PanierRepository $paniers): Response
    {
        return $this->render('contact.html.twig', [
            'categories' => $categorie->findAll(),
            'paniers' => $paniers->findBy(array('user'=>$this->getUser())),
        ]);
    }

    #[Route('/apropos', name: 'app_apropos')]
    public function apropos(CategorieRepository $categorie, PanierRepository $paniers): Response
    {
        return $this->render('apropos.html.twig', [
            'categories' => $categorie->findAll(),
            'paniers' => $paniers->findBy(array('user'=>$this->getUser())),
        ]);
    }
}
