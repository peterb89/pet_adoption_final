<?php

namespace App\Controller\Admin\Adoption;

use App\Entity\AdoptionApplication;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class AdoptionApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AdoptionApplication::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user', 'User / Adopter'),
            AssociationField::new('animal', 'Animal to Adopt'),
            TextField::new('status'),
            TextEditorField::new('message'),
            DateTimeField::new('createdAt'),
        ];
    }
}