<?php

namespace App\Form;

use App\Entity\CoachGroup;
use App\Entity\UserProfile;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', null, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('firstName', null, [
                'label' => 'Prénom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateOfBirth', null, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                'max' => new DateTime()->format('Y-m-d'),
                ],
            ])
            ->add('placeOfBirth', null, [
                'label' => 'Lieu de naissance',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Lieu de naissance'
                ]
            ])
            ->add('address', null, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('preferredGroup', ChoiceType::class, [
                'label' => 'Groupe principal',
                'required' => false,
                'choices' => [
                    'Debutant' => 'BEGINNER',
                    'Intermediaire' => 'INTERMEDIATE',
                    'Competition' => 'COMPETITION',
                    'Inclusif / adapte' => 'INCLUSIVE',
                ],
                'placeholder' => 'Selectionner',
            ])
            ->add('adaptedSupport', null, [
                'label' => 'Besoin de séances adaptees',
                'required' => false,
            ])
            ->add('specificNeeds', TextareaType::class, [
                'label' => 'Besoins specifiques',
                'required' => false,
                'attr' => ['rows' => 3],
            ])
            ->add('personalObjective', null, [
                'label' => 'Objectif personnel',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: remise en forme, confiance, competition douce'],
            ])
            ->add('coachGroup', EntityType::class, [
                'class' => CoachGroup::class,
                'choice_label' => 'name',
                'label' => 'Groupe coach',
                'required' => false,
                'placeholder' => 'Aucun groupe',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
        ]);
    }
}
