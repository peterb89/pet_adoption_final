<?php

namespace App\Form;

use App\Entity\Profile\HousingType;
use App\Entity\Profile\Profile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('phoneNumber')
            ->add('city')
            ->add('address')
            ->add('motivation', TextareaType::class, [
                'mapped' => false,
                'attr' => ['rows' => 5, 'placeholder' => 'Tell us why you want to adopt...'],
                'label' => 'Description / Motivation (optional)',
            ])
            ->add('housingType', EntityType::class, [
                'class' => HousingType::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
