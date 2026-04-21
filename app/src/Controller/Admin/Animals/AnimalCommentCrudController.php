<?php

namespace App\Controller\Admin\Animals;

use App\Entity\Animals\AnimalComment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class AnimalCommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnimalComment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            AssociationField::new('author'),
            AssociationField::new('animal'),

            TextEditorField::new('message'),

            DateTimeField::new('createdAt')
                ->hideOnForm(),
        ];
    }
}