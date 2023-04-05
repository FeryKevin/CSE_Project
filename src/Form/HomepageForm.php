<?php

namespace App\Form;

use App\Entity\CSE;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class HomepageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('presentationHome', CKEditorType::class, [
                'label' => "Message sur l'accueil :",
                'constraints' => new Assert\NotBlank([
                    'message' => 'Entrez un message',
                ]),
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => "offer-button"],
                'label' => "Valider"
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CSE::class,
        ]);
    }
}
