<?php
 
namespace App\Controller\Admin\Animals;
 
use App\Entity\Animals\Animal;
use App\Service\FileUploadService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
 
class AnimalCrudController extends AbstractCrudController
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

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
            ChoiceField::new('status')->setChoices([
                'Available' => 'available',
                'Not available' => 'not_available',
            ])->renderAsBadges(false),
            ChoiceField::new('size')->setChoices([
                'Small'  => 'small',
                'Medium' => 'medium',
                'Large'  => 'large',
            ])->allowMultipleChoices(false)->renderAsBadges(false),
            ChoiceField::new('gender')->setChoices([
                'Male'   => 'male',
                'Female' => 'female',
            ])->allowMultipleChoices(false)->renderAsBadges(false),
            ImageField::new('photoFilename')
                ->setBasePath('uploads')
                ->onlyOnIndex(),
            Field::new('imageFile')
                ->setFormType(FileType::class)
                ->setLabel('Animal picture')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Animal) {
            $this->handleImageUpload($entityInstance);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Animal) {
            $this->handleImageUpload($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function handleImageUpload(Animal $animal): void
    {
        $imageFile = $animal->getImageFile();

        if (!$imageFile) {
            return;
        }

        $this->fileUploadService->remove($animal->getPhotoFilename());
        $animal->setPhotoFilename($this->fileUploadService->upload($imageFile, 'animals'));
        $animal->setImageFile(null);
    }
}
 