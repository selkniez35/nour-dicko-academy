<?php

namespace App\Form;

use App\Entity\Recording;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class RecordingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre (optionnel)',
                'required' => false,
                'attr' => ['placeholder' => "Ex : Séance du 20/07 — rattrapage"],
            ])
            ->add('file', FileType::class, [
                'label' => 'Fichier vidéo',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(message: 'Veuillez sélectionner un fichier vidéo.'),
                    new File(
                        maxSize: '2048M',
                        mimeTypes: [
                            'video/mp4',
                            'video/quicktime',
                            'video/webm',
                            'video/x-msvideo',
                            'video/x-matroska',
                        ],
                        mimeTypesMessage: 'Formats acceptés : MP4, MOV, WEBM, AVI, MKV.',
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recording::class,
        ]);
    }
}
