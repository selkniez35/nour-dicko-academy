<?php

namespace App\Form;

use App\Entity\TrainingSession;
use App\Enum\TrainingSessionTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class, [
                'required' => false
            ])
            ->add('startAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Début',
                'html5' => true,
            ])

            ->add('endAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Fin',
                'html5' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => TrainingSessionTypeEnum::choices(),
                'label' => 'Type de séance'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingSession::class,
        ]);
    }
}