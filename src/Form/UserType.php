<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

class UserType extends AbsgitractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $builder->getData();

        dd($this->container->getParameter('security.role_hierarchy.roles'));
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices'  => RoleHierarchy::getReachableRoles()
            ])
            ->add('password', options: ['data' => null, 'required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
