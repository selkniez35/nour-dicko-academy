<?php

namespace App\Form;

use App\Entity\Announcement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['rows' => 6],
            ])
            ->add('audience', ChoiceType::class, [
                'label' => 'Cible',
                'choices' => [
                    'Tout le club' => 'ALL',
                    'Debutants' => 'BEGINNER',
                    'Intermediaires' => 'INTERMEDIATE',
                    'Competiteurs' => 'COMPETITION',
                    'Inclusif / adapte' => 'INCLUSIVE',
                ],
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publier maintenant',
                'required' => false,
            ])
            ->add('sendEmail', CheckboxType::class, [
                'label' => 'Envoyer un email a la cible',
                'required' => false,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
