<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\PanierType;
use App\Repository\AdresseRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
//    #[Route('/compte', name: 'app_compte')]
//    public function index(ProduitRepository $produit, CategorieRepository $categorie): Response
//    {
//        return $this->render('compte/index.html.twig', [
//            'produits' => $produit->findAll(),
//            'categories' => $categorie
//        ]);
//    }

    #[Route('/souhait', name: 'app_souhait')]
    public function souhait(ProduitRepository $produit, CategorieRepository $categorie): Response
    {
        return $this->render('compte/souhait.html.twig', [
            'produits' => $produit->findAll(),
            'categories' => $categorie
        ]);
    }

    #[Route('/panier', name: 'app_panier')]
    public function panier(ManagerRegistry $doctrine, PanierRepository $panier, ProduitRepository $produit, CategorieRepository $categorie, ?Panier $paniers, Request $request): Response
    {

        return $this->render('compte/panier.html.twig', [
            'paniers' => $panier->findBy(array('user'=>$this->getUser())),
            'produits' => $produit->findAll(),
            'categories' => $categorie->findAll(),
            'panier' => $paniers,
        ]);

    }

    #[Route('/compte', name: 'app_compte')]
    public function gestion_compte(CategorieRepository $categorie, PanierRepository $paniers, AdresseRepository $adresse, CommandeRepository $commande): Response
    {
        return $this->render('compte/gestion_compte/compte.html.twig', [
            'categories' => $categorie->findAll(),
            'paniers' => $paniers->findBy(array('user'=>$this->getUser())),
            'adresse' => $adresse->findBy(array('user'=>$this->getUser())),
            'commandes' => $commande->findBy(array('user'=>$this->getUser())),
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/gestion_compte/commande', name: 'app_gescompte_com')]
    public function gestion_compte_com(CategorieRepository $categorie, PanierRepository $paniers, CommandeRepository $commande): Response
    {
        return $this->render('compte/gestion_compte/commande.html.twig', [
            'categories' => $categorie->findAll(),
            'paniers' => $paniers->findBy(array('user'=>$this->getUser())),
            'commandes' => $commande->findBy(array('user'=>$this->getUser()), array('createdAt'=>'desc')),
        ]);
    }

    #[Route('/gestion_compte/adresse', name: 'app_gescompte_ad')]
    public function gestion_compte_ad(CategorieRepository $categorie, PanierRepository $paniers, AdresseRepository $adressse): Response
    {
        return $this->render('compte/gestion_compte/adresse.html.twig', [
            'categories' => $categorie->findAll(),
            'paniers' => $paniers->findBy(array('user'=>$this->getUser())),
            'adresse' => $adressse->findBy(array('user'=>$this->getUser())),
        ]);
    }
}
