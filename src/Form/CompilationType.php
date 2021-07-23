<?php

namespace App\Form;

use App\Entity\Compilation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CompilationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('youtube', TextareaType::class, [
                'attr' => [
                    'class' => 'text-blue-300 peer placeholder-transparent h-32 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600'
                ],
                'mapped' => false,
                'label' => 'Liens youtube',
                    'required' => false,
                ]
            )
            ->add('spotify', TextareaType::class, [
                'mapped' => false,
                'label' => 'Liens spotify',
                'required' => false,
                'attr' => [
                    'class' => 'text-blue-300 peer placeholder-transparent h-32 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600'
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'text-blue-300 peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre de la collection',
                'attr' => [
                    'class' => 'text-blue-300 peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600'
                ]
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
