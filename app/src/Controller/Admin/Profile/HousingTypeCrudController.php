<?php

namespace App\Controller\Admin\Profile;

use App\Entity\Profile\HousingType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HousingTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HousingType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
        ];
    }
}