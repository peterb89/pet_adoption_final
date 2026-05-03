<?php

namespace App\Form;

use App\Entity\AdoptionApplication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdoptionApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => 'Why do you want to adopt this pet?',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Tell us a little about yourself and your home...',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdoptionApplication::class,
        ]);
    }
}
