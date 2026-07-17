<?php

namespace App\Form;

use App\Entity\CourseSession;
use App\Entity\MembershipPlan;
use App\Entity\User;
use App\Enum\UserRole;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CourseSessionType extends AbstractType
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plan', EntityType::class, [
                'class' => MembershipPlan::class,
                'choice_label' => 'label',
                'label' => 'Classe',
                'placeholder' => 'Sélectionner une classe',
                'constraints' => [
                    new NotBlank(message: 'Veuillez sélectionner une classe.'),
                ],
            ])
            ->add('teacher', EntityType::class, [
                'class' => User::class,
                'choices' => array_filter(
                    $this->userRepository->findAll(),
                    fn (User $u) => in_array(UserRole::TEACHER->value, $u->getRoles(), true)
                ),
                'choice_label' => static fn (User $u): string => trim($u->getProfile()->getFullName()),
                'label' => 'Enseignant',
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
