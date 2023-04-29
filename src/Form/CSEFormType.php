<?php

namespace App\Form;

use App\Entity\CSE;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CSEFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('presentationHome', CKEditorType::class, [
                'label' => "Message de présentation :",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Ce champs ne peut pas être vide',
                ]),
            ])
            ->add('presentationAbout', CKEditorType::class, [
                'label' => "A propos du CSE :",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Ce champs ne peut pas être vide',
                ]),
            ])
            ->add('rules', CKEditorType::class, [
                'label' => "Règles du CSE :",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Ce champs ne peut pas être vide',
                ]),
            ])
            ->add('actions', CKEditorType::class, [
                'label' => "Actions du CSE :",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Ce champs ne peut pas être vide',
                ]),
            ])
            ->add('email', options: [
                'label' => "Email du CSE :",
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Renseignez votre email',
                    ]),
                    new Assert\Email([
                        'message' => 'Renseignez un email correct',
                    ]),
                ],
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
