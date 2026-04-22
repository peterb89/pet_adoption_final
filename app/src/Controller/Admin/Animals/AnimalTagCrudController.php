<?php

namespace App\Controller\Admin\Animals;

use App\Entity\Animals\AnimalTag;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class AnimalTagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnimalTag::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('animal'),
            AssociationField::new('tag'),
        ];
    }
}
