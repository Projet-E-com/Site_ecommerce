<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique')]
    public function index(CategorieRepository $categories, ProduitRepository $produits): Response
    {
        return $this->render('boutique/index.html.twig', [
            'categories' => $categories->findAll(),
            'produits' => $produits->findAll()
        ]);
    }

    #[Route('/boutique/categorie/{id}', name: 'app_boutique_categorie')]
    public function categorie(?Categorie $categorie, CategorieRepository $categories, ProduitRepository $produits): Response
    {
        return $this->render('boutique/produit_categorie.html.twig', [
            'categories' => $categories->findAll(),
            'categorie' => $categorie,
            'produits' => $produits->findAll()
        ]);
    }

    #[Route('/boutique/sous_categorie/{id}', name: 'app_boutique_souscategorie')]
    public function sous_catrgorie(SousCategorie $souscategorie, ProduitRepository $produits, CategorieRepository $categories): Response
    {
        return $this->render('boutique/produit_sous-categorie.html.twig', [
            'souscategorie' => $souscategorie,
            'produits' => $produits->findAll(),
            'categories' => $categories->findAll()
        ]);
    }

    #[Route('/boutique/detail/{id}', name: 'app_boutique_detail')]
    public function details(?Produit $produit, CategorieRepository $categories): Response
    {
        return $this->render('boutique/produit_details.htnl.twig', [
            'produits' => $produit,
            'categories' => $categories->findAll(),
        ]);
    }
}
