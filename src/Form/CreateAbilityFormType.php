<?php

namespace App\Form;

use App\Entity\Abilities;
use App\Entity\Heroes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateAbilityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('heroes', EntityType::class, [
                'label' => 'Héros',
                'class' => Heroes::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'abilité',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ],
                'row_attr' => ['class' => 'trick-description-aera', 'rows' => "10"]
            ])
            ->add('spellsIcons', FileType::class, [
                'label' => 'Définir une image pour la capacité',
                'multiple' => false,
                'mapped' => false,
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abilities::class,
        ]);
    }
}
