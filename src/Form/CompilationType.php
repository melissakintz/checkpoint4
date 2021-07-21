<?php

namespace App\Form;

use App\Entity\Compilation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompilationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('youtubeLinks', TextType::class, [
                'label' => 'Liens youtube'
                ]
            )
            ->add('spotifyLinks', TextType::class, [
                'label' => 'Liens spotify'
            ])
            ->add('applemusicLinks', TextType::class, [
                'label' => 'Liens apple music'
            ])
            ->add('description', TextType::class, [
                'label' => 'Liens youtube'
            ])
            ->add('title', TextType::class, [
                'label' => 'Liens youtube'
            ])
            ->add('private', ChoiceType::class, [
                'label' => 'Privé ?',
                'choices' => [
                    'oui' => true,
                    'non' => false
                ],
                'expanded' => true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Compilation::class,
        ]);
    }
}
