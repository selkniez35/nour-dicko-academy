<?php

namespace App\Form;

use App\Entity\CourseSession;
use App\Entity\MembershipPlan;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plan', EntityType::class, [
                'class' => MembershipPlan::class,
                'choice_label' => 'label',
                'label' => 'Classe',
                'placeholder' => 'Sélectionner une classe',
            ])
            ->add('teacher', EntityType::class, [
                'class' => Teacher::class,
                'choice_label' => static fn (Teacher $t): string => trim($t->getFirstName() . ' ' . $t->getLastName()),
                'label' => 'Enseignant',
                'required' => false,
                'placeholder' => 'Aucun enseignant',
            ])
            ->add('startsAt', DateTimeType::class, [
                'label' => 'Début',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('endsAt', DateTimeType::class, [
                'label' => 'Fin',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('room', TextType::class, [
                'label' => 'Salle',
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: Salle 1, en ligne...'],
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Notes',
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Informations complémentaires'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseSession::class,
        ]);
    }
}
