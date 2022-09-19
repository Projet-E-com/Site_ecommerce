<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/ajout_panier/{id}', name: 'add_panier')]
    public function ajoutpanier(int $id, ManagerRegistry $doctrine, ProduitRepository $produit, CategorieRepository $categorie, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $panier = new Panier();
        $panier
            ->setProduit($produit->find($id))
            ->setUser($this->getUser())
        ;

        $entityManager->persist($panier);

        $entityManager->flush();

        return $this->redirectToRoute($request->attributes->get('_route'),[
            'categories' => $categorie->findAll(),
            'produit' => $produit->findAll(),
        ]);
    }
}
