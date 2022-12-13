<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(EntityManagerInterface $entityManager, PanierRepository $panier,CommandeRepository $commandes, ProduitRepository $produit, CategorieRepository $categorie, ?Produit $produits, Request $request): Response
    {
        $address = new Adresse();
        $pan = $panier->findBy(array('user'=>$this->getUser()));
        $form = $this->createForm(AdresseType::class, $address);
        $form->handleRequest($request);
        $address->setUser($this->getUser())
                ->setCreatedAt(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {

            // ecrire un algo pour la creation du nemuero de comamande

            $lettre = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $melange = str_shuffle($lettre);
            $num = substr($melange, 0, 8);

            // ici enregistrement de la commande

            $commande = new Commande();
            $commande->setNumero($num)
                ->setFraisLivraison(1500)
                ->setUser($this->getUser())
                ->setCreatedAt(new \DateTime());

            // faire persister et flusher les elements

            $entityManager->persist($address);
            $entityManager->persist($commande);
            $entityManager->flush();

            $id = $commande->getId();

            return $this->render('commande/commande_valide.html.twig', [
                'id_cmd' => $id,
                'commande_num'=>$num,
                'commandes' => $commandes->findBy(array('user'=>$this->getUser())),
                'paniers' => $panier->findBy(array('user'=>$this->getUser())),
                'produits' => $produit->findAll(),
                'categories' => $categorie->findAll(),
            ]);
        }

        return $this->render('commande/index.html.twig', [
            'paniers' => $panier->findBy(array('user'=>$this->getUser())),
            'produits' => $produit->findAll(),
            'categories' => $categorie->findAll(),
            'produit' => $produits,
            'adresse_form' => $form->createView(),
        ]);


    }

    #[Route('/commande/validation/{id}', name: 'app_comdvalid')]
    public function validation(int $id, AdresseRepository $adresse, EntityManagerInterface $entityManager, PanierRepository $paniers, CategorieRepository $categories, CommandeRepository $commandes){


        $pan = $paniers->findAll();
         foreach ($pan as $qte){
             $procmd = new CommandeProduit();
            $procmd->setCommandeId($commandes->find($id))
                ->setQuantite($qte->getQuantite())
                ->setProduit($qte->getProduit());

            $entityManager->persist($procmd);
            $entityManager->remove($qte);

         }

         $entityManager->flush();

         $transport = Transport::fromDsn('smtp://samanhugues@gmail.com:paecqataytwhtdys@smtp.gmail.com:587');
         $mailer =  new Mailer($transport);
         $email = (new Email());
         $email->from('samanhugues@gmail.com');
         $email->to($this->getUser()->getUserIdentifier());
         $email->subject('Confirmation de commande');
         $email->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');

         $mailer->send($email);


        return $this->render('compte/gestion_compte/compte.html.twig', [
            'categories' => $categories->findAll(),
            'paniers' => $paniers->findBy(array('user'=>$this->getUser())),
            'adresse' => $adresse->findBy(array('user'=>$this->getUser())),
            'commandes' => $commandes->findBy(array('user'=>$this->getUser())),
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/commande/annuler/{id}', name: 'app_comdsup')]
    public function annulation(int $id, ManagerRegistry $doctrine, Request $request, Commande $commandes) : Response{

        $entityManager = $doctrine->getManager();

        $commandes->getId($id);

        $entityManager->remove($commandes);

        $entityManager->flush();

        return $this->render('home/index.html.twig');
    }
}
