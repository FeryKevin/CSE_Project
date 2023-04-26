<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'label' => "Nom",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez entrer un nom',
                ]),
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez entrer une description',
                ]),
            ])
            ->add('limitedDisplayBeginning', DateTimeType::class, [
                'label' => "Date de début d'affichage",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez entrer une date de début d\'affichage',
                ]),
            ])
            ->add('limitedDisplayEnding', DateTimeType::class, [
                'label' => "Date de fin d'affichage",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Veuillez entrer une date de fin d\'affichage',
                ]),
            ])
            ->add('limitedDisplayNumber', IntegerType::class, [
                'label' => "Numéro d'affichage (0-10)",
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
                ]
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => FileForm::class,
                'entry_options' => [
                    'attr' => [
                        'onChange' => 'checkImagesInputs()'
                    ],
                    'data_class' => File::class,
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Images (png/jpg/jpeg/webp)'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => ['class' => 'offer-button submit-offer'],
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
