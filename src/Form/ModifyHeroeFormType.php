<?php

namespace App\Form;

use App\Entity\Heroes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyHeroeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du héros',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'description du héros',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])

            ->add('role', EntityType::class, [
                'label' => 'Classe',
                'class' => Roles::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('medias', FileType::class, [
                'label' => 'Définir une image pour le héros',
                'multiple' => false,
                'mapped' => false,
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('counter', EntityType::class, [
                'label' => 'Votre personne va être contré par :',
                'class' => Heroes::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'choice_attr' => [
                    'class' => ''
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Heroes::class,
        ]);
    }
}
