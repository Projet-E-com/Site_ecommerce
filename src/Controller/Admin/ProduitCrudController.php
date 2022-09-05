<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Form\ImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitCrudController extends AbstractCrudController
{


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('sousCategorie', 'Sous Categorie');
        yield TextField::new('nom');
        yield TextEditorField::new('Description');
        yield MoneyField::new('prix_reduit')->setCurrency('XOF');
        yield MoneyField::new('prix')->setCurrency('XOF');
        yield TextField::new('marque');
        yield TextField::new('nom_vendeur');
        yield NumberField::new('contact_vendeur');
        yield CollectionField::new('image')
            ->setEntryType(ImageType::class)
            ->onlyOnForms();
        yield BooleanField::new('disponibilite');
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }

}
