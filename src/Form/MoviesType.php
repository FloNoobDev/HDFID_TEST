<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoviesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)

            ->add('forAdult', CheckboxType::class, [
                'required' => false,
            ])

            ->add('language', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Français' => 'fr-FR',
                    'English US' => 'en-US',
                ],
                'data' => 'fr-FR'
            ])

            ->add('submit', SubmitType::class)
            ->add('cancel', ResetType::class)
            ->add('honeypot',HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
