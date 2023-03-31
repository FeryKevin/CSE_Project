<?php

namespace App\Form;

use App\Entity\CSE;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CSEFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', options: [
                'label' => "Email sur la page présentation",
            ])
            ->add('presentationAbout', CKEditorType::class, [
                'label' => "Texte sur la page présentation",
            ])
            ->add('rules', CKEditorType::class, [
                'label' => "Règles sur la page présentation",
            ])
            ->add('actions', CKEditorType::class, [
                'label' => "Actions sur la page présentation",
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => "offer-button"],
                'label' => "Valider"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CSE::class,
        ]);
    }
}
