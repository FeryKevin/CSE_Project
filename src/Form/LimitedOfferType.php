<?php

namespace App\Form;

use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LimitedOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom",
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description",
            ])
            ->add('limitedDisplayBeginning', DateTimeType::class, [
                'required' => false,
                'label' => "Date de début d'affichage",
            ])
            ->add('limitedDisplayEnding', DateTimeType::class, [
                'required' => false,
                'label' => "Date de fin d'affichage",
            ])
            ->add('limitedDisplayNumber', TextType::class, [
                'required' => false,
                'label' => "Numéro d'affichage",
            ])
            ->add('limitedDisplayNumber', ChoiceType::class, [
                'label' => "Numéro d'affichage",
                'required' => false,
                'choices'  => [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ],
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => FileForm::class,
                // 'entry_options' => ['label' => false],
                // 'allow_add' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => ['class' => 'offer-button'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
