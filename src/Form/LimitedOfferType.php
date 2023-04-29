<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class LimitedOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez entrer un nom',
                ]),
                'empty_data' => '',
                'label' => "Nom",
            ])
            ->add('description', TextareaType::class, [
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez entrer une description',
                ]),
                'empty_data' => '',
                'label' => "Description",
            ])
            ->add('limitedDisplayBeginning', DateTimeType::class, [
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez entrer une date de début d\'affichage',
                ]),
                'data' => new \Datetime,
                'label' => "Date de début d'affichage",
            ])
            ->add('limitedDisplayEnding', DateTimeType::class, [
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez entrer une date de fin d\'affichage',
                ]),
                'data' => new \Datetime,
                'label' => "Date de fin d'affichage",
            ])
            ->add('limitedDisplayNumber', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez entrer un numéro d\'affichage',
                    ]),
                    new Assert\GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Veuillez entrer un nombre compris entre 0 et 10',
                    ]),
                    new Assert\LessThanOrEqual([
                        'value' => 10,
                        'message' => 'Veuillez entrer un nombre compris entre 0 et 10',
                    ]),
                ],
                'label' => "Numéro d'affichage (0-10)",
            ])
            ->add('images', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'attr' => [
                        'onChange' => 'checkImagesInputs()'
                    ],
                    'data_class' => File::class,
                    'label' => false,
                ],
                'entry_type' => FileForm::class,
                'label' => 'Images (png/jpg/jpeg/webp)'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'offer-button submit-offer'],
                'label' => "Valider",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
            'on_edit' => false,
        ]);
    }
}
