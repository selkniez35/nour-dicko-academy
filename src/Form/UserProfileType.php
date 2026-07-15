<?php

namespace App\Form;

use App\Entity\UserProfile;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom']
            ])
            ->add('firstName', null, [
                'label' => 'Prénom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom']
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
                'attr' => ['class' => 'form-control', 'placeholder' => 'Adresse'],
            ])
            ->add('memberships', CollectionType::class, [
                'entry_type' => MembershipType::class,
                'allow_add' => true,
                'by_reference' => false,
                'label' => false,
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
        ]);
    }
}
