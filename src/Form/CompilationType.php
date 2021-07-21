<?php

namespace App\Form;

use App\Entity\Compilation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompilationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('youtubeLinks')
            ->add('spotifyLinks')
            ->add('applemusicLinks')
            ->add('description')
            ->add('title')
            ->add('date')
            ->add('private')
            ->add('likes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Compilation::class,
        ]);
    }
}
