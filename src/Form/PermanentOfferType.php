<?php

namespace App\Form;

use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermanentOfferType extends AbstractType
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
            ->add('permanentValidityBeginning', DateTimeType::class, [
                'required' => false,
                'label' => "Date de début de validité",
            ])
            ->add('permanentValidityEnding', DateTimeType::class, [
                'required' => false,
                'label' => "Date de fin de validité",
            ])
            ->add('permanentMinimumPlaces', TextType::class, [
                'required' => false,
                'label' => "Nombre de places minimal",
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
            'on_edit' => false,
        ]);
    }
}
