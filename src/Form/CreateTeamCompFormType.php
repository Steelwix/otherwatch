<?php

namespace App\Form;

use App\Entity\Heroes;
use App\Entity\TeamComps;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTeamCompFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la composition',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])
            ->add('tank', EntityType::class, [
                'label' => 'Tank',
                'class' => Heroes::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('firstDamage', EntityType::class, [
                'label' => 'DPS',
                'class' => Heroes::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('secondDamage', EntityType::class, [
                'label' => 'DPS',
                'class' => Heroes::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('firstSupport', EntityType::class, [
                'label' => 'Support',
                'class' => Heroes::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
            ])
            ->add('secondSupport', EntityType::class, [
                'label' => 'Support',
                'class' => Heroes::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeamComps::class,
        ]);
    }
}
