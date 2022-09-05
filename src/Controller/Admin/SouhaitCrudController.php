<?php

namespace App\Controller\Admin;

use App\Entity\Souhait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SouhaitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Souhait::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
