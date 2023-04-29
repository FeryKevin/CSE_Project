<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('roles', ChoiceType::class, [
            'choices' => ['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER', 'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN'],
            'multiple' => true,
            'label' => 'Rôles :',
            'row_attr' => ['class' => 'user-form']
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email :',
            'row_attr' => ['class' => 'user-form'],
            'constraints' => [
                new Assert\Email([
                    'message' => 'L\'email {{ value }} n\'est pas valide.',
                ]),
                new Assert\NotBlank()
            ],
        ]);
            
        if (null === $builder->getData()->getId()) {
            $builder->add('password', PasswordType::class, ['label' => 'Mot de passe', 'row_attr' => ['class' => 'user-form']]);
        } else {
            $builder->add('plainPassword', PasswordType::class, ['data' => null, 'required' => false, 'label' => 'Mot de passe :', 'row_attr' => ['class' => 'user-form']]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "allow_extra_fields" => true,
        ]);
    }
}
