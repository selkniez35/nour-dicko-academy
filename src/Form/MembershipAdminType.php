<?php

namespace App\Form;

use App\Entity\Membership;
use App\Entity\MembershipPlan;
use App\Enum\MembershipStatus;
use App\Enum\PaymentMethod;
use App\Enum\PaymentModeEnum;
use App\Enum\StudentLevelEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembershipAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('season', TextType::class, [
                'label' => 'Saison',
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Actif' => MembershipStatus::ACTIVE,
                    'Suspendu' => MembershipStatus::SUSPENDED,
                    'En attente' => MembershipStatus::PENDING,
                ],
                'choice_value' => static fn (?MembershipStatus $status): ?string => $status?->value,
                'choice_label' => static fn (MembershipStatus $status): string => $status->label(),
            ])
            ->add('studentLevel', EnumType::class, [
                'class' => StudentLevelEnum::class,
                'choice_label' => static fn (StudentLevelEnum $level): string => $level->label(),
                'label' => 'Niveau',
                'required' => false,
                'placeholder' => 'Non renseigné',
            ])
            ->add('paymentMode', EnumType::class, [
                'class' => PaymentModeEnum::class,
                'choice_label' => static fn (PaymentModeEnum $mode): string => $mode->label(),
                'label' => 'Mode de paiement',
                'required' => false,
                'placeholder' => 'Non renseigné',
            ])
            ->add('paymentMethod', EnumType::class, [
                'class' => PaymentMethod::class,
                'choice_label' => static fn (PaymentMethod $method): string => $method->label(),
                'label' => 'Moyen de paiement',
                'required' => false,
                'placeholder' => 'Non renseigné',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'required' => false,
            ])
            ->add('selectedCourses', EntityType::class, [
                'class' => MembershipPlan::class,
                'choice_label' => 'label',
                'label' => 'Formations',
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'tom-select',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membership::class,
        ]);
    }
}
