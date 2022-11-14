<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\AdresseType;
use App\Repository\CategorieRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(EntityManagerInterface $entityManager, PanierRepository $panier, ProduitRepository $produit, CategorieRepository $categorie, ?Produit $produits, Request $request, User $user): Response
    {
        if ($this->getUser())
        $address = new Adresse();

        $form = $this->createForm(AdresseType::class, $address);
        $form->handleRequest($request);
        $address->setUser($this->getUser())
        ->setCreatedAt(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($address);
            $entityManager->flush();
            return $this->render('compte/index.html.twig', [
                'paniers' => $panier->findAll(),
                'produits' => $produit->findAll(),
                'categories' => $categorie->findAll(),
            ]);
        }

        return $this->render('commande/index.html.twig', [
            'paniers' => $panier->findAll(),
            'produits' => $produit->findAll(),
            'categories' => $categorie->findAll(),
            'produit' => $produits,
            'adresse_form' => $form->createView(),
        ]);


    }
}
