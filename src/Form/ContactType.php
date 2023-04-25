<?php

namespace App\Form;

use App\Entity\Contact;
use PixelOpen\CloudflareTurnstileBundle\Type\TurnstileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => new Assert\NotBlank(
                    ['message' => 'Renseignez votre nom',]
                ),
                'label' => 'Nom :',
            ])
            ->add('firstName', TextType::class, [
                'constraints' => new Assert\NotBlank(['message' => 'Renseignez votre prénom',]),
                'label' => 'Prénom :'
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Renseignez votre email',
                    ]),
                    new Assert\Email([
                        'message' => 'Renseignez un email correct',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'constraints' => new Assert\NotBlank(['message' => 'Renseignez votre message',]),
                'label' => 'Message :'
            ])
            ->add('newsletter', CheckboxType::class, [
                'label' => 'Je souhaite m\'inscrire à la newsletter',
                'mapped' => false,
                'required' => false,
            ])
            ->add('security', TurnstileType::class, [
                'attr' => ['data-action' => 'contact', 'data-theme' => 'dark'], 'label' => false,
            ])
            ->add('sumbit', SubmitType::class, ['label' => 'Envoyer']);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
