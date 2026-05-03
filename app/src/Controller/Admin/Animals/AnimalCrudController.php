<?php
 
namespace App\Controller\Admin\Animals;
 
use App\Entity\Animals\Animal;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
 
class AnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }
 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('species'),
            TextField::new('breed'),
            IntegerField::new('age'),
            TextField::new('location'),
            TextField::new('status'),
            ChoiceField::new('size')->setChoices([
                'Small'  => 'small',
                'Medium' => 'medium',
                'Large'  => 'large',
            ])->allowMultipleChoices(false)->renderAsBadges(false),
            ChoiceField::new('gender')->setChoices([
                'Male'   => 'male',
                'Female' => 'female',
            ])->allowMultipleChoices(false)->renderAsBadges(false),
        ];
    }
}
 