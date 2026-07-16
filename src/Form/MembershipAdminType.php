<?php

namespace App\Form;

use App\Entity\Membership;
use App\Entity\MembershipPlan;
use App\Enum\MembershipStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('studentLevel', ChoiceType::class, [
                'label' => 'Niveau',
                'required' => false,
                'placeholder' => 'Non renseigné',
                'choices' => [
                    "Lire l'arabe et le Coran de manière fluide" => 'fluide',
                    "Lire l'arabe et le Coran mais avec quelques difficultés" => 'difficultes',
                    'Reconnaître quelques lettres' => 'quelques-lettres',
                    "Je ne sais pas lire l'arabe ni le Coran" => 'rien',
                ],
            ])
            ->add('paymentMode', TextType::class, [
                'label' => 'Mode de paiement',
                'required' => false,
            ])
            ->add('paymentMethod', TextType::class, [
                'label' => 'Moyen de paiement',
                'required' => false,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'required' => false,
            ])
            ->add('selectedCourses', EntityType::class, [
                'class' => MembershipPlan::class,
                'choice_label' => 'label',
                'label' => 'Formules choisies à l\'inscription',
                'multiple' => true,
                'required' => false,
            ])
            ->add('plan', EntityType::class, [
                'class' => MembershipPlan::class,
                'choice_label' => 'label',
                'label' => 'Formule principale',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membership::class,
        ]);
    }
}
