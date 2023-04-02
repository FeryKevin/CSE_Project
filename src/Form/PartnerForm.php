<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

final class PartnerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, [
            'label' => 'Nom :',
            'empty_data' => '',
            'attr' => [
                'placeholder' => 'Nom',
            ],
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ])
            ->add('description', TextType::class, [
                'label' => 'Description :',
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Description',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('websiteLink', TextType::class, [
                'label' => 'Lien du site :',
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Site Web',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('image', FileForm::class, [
                'label' => 'Image :',
            ])
            ->add('submit', SubmitType::class, [
                'label' => $builder->getOption('on_edit') ? 'Modifier' : 'Ajouter',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
            'on_edit' => false,
        ]);
    }
}