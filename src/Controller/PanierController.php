<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Souhait;
use App\Form\PanierType;
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
        $element = $produit->find($id);
        $panier = new Panier();
        $panier
            ->setProduit($produit->find($id))
            ->setUser($this->getUser())
            ->setQuantite(1)
            ->setPrix($element->getPrix())
        ;

        $entityManager->persist($panier);

        $entityManager->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/suppression-panier/{id}', name: 'sup_panier')]
    public function sup_panier(int $id, ManagerRegistry $doctrine, Request $request, Panier $panier): Response
    {
        $entityManager = $doctrine->getManager();

        $panier->getId($id);

        $entityManager->remove($panier);

        $entityManager->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/update-panier/{id}', name: 'update_panier')]
    public function update_panier(int $id, ManagerRegistry $doctrine, Request $request, Panier $panier): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist();
            $entityManager->flush();
            return $this->render('home/index.html.twig', [

            ]);
        }

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }


    #[Route('/ajout_souhait/{id}', name: 'add_souhait')]
    public function ajoutsouhait(int $id, ManagerRegistry $doctrine, ProduitRepository $produit, CategorieRepository $categorie, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $souhait = new Souhait();
        $souhait
            ->setProduit($produit->find($id))
            ->setUser($this->getUser())
        ;

        $entityManager->persist($souhait);

        $entityManager->flush();

        return $this->redirectToRoute('app_home',[
            'categories' => $categorie->findAll(),
            'produit' => $produit->findAll(),
        ]);
    }


}
