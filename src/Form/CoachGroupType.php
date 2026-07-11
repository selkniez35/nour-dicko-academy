<?php

namespace App\Form;

use App\Entity\CoachGroup;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoachGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label' => 'Nom du groupe'])
            ->add('level', ChoiceType::class, [
                'label' => 'Niveau',
                'choices' => [
                    'Debutant' => 'BEGINNER',
                    'Intermediaire' => 'INTERMEDIATE',
                    'Competition' => 'COMPETITION',
                    'Inclusif' => 'INCLUSIVE',
                ],
            ])
            ->add('isInclusive', null, [
                'label' => 'Groupe inclusif',
                'required' => false,
            ])
            ->add('coach', EntityType::class, [
                'class' => User::class,
                'label' => 'Coach responsable',
                'required' => false,
                'choice_label' => 'email',
                'placeholder' => 'Aucun',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CoachGroup::class,
        ]);
    }
}
