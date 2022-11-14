<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route('/compte', name: 'app_compte')]
    public function index(ProduitRepository $produit, CategorieRepository $categorie): Response
    {
        return $this->render('compte/index.html.twig', [
            'produits' => $produit->findAll(),
            'categories' => $categorie
        ]);
    }

    #[Route('/souhait', name: 'app_souhait')]
    public function souhait(ProduitRepository $produit, CategorieRepository $categorie): Response
    {
        return $this->render('compte/souhait.html.twig', [
            'produits' => $produit->findAll(),
            'categories' => $categorie
        ]);
    }

    #[Route('/panier', name: 'app_panier')]
    public function panier(PanierRepository $panier, ProduitRepository $produit, CategorieRepository $categorie, ?Panier $paniers): Response
    {


        return $this->render('compte/panier.html.twig', [
            'paniers' => $panier->findBy(array('user'=>$this->getUser())),
            'produits' => $produit->findAll(),
            'categories' => $categorie->findAll(),
            'panier' => $paniers,

        ]);


    }
}
