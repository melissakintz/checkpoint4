<?php

namespace App\Form;

use App\Entity\Compilation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CompilationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('youtube', TextType::class, [
                'mapped' => false,
                'label' => 'Liens youtube',
                    'required' => false,
                ]
            )
            ->add('spotify', TextType::class, [
                'mapped' => false,
                'label' => 'Liens spotify',
                'required' => false
            ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre du mood board'
            ])
            ->add('pictures', FileType::class, [
                'mapped' => false,
                'required' =>false,
                'multiple' => true,
                'label' => false
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
