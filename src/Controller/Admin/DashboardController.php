<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $url = $this->adminUrlGenerator->setController(ProduitCrudController::class)
            ->generateUrl();

        return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ecom Version Test');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Produits', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Voir categorie', 'fas fa-list', Categorie::class),
            MenuItem::linkToCrud('Voir sous categorie', 'fas fa-list', SousCategorie::class),
            MenuItem::linkToCrud('Tous les produits', 'fas fa-newspaper', Produit::class),
            MenuItem::linkToCrud('Ajout produit', 'fas fa-plus', Produit::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::linkToCrud('Client', '', User::class);
        yield MenuItem::linkToCrud('Commande', '', Commande::class);
        yield MenuItem::linkToCrud('Adresse', '', Adresse::class);
    }
}
