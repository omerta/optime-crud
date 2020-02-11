<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use App\Entity\Category;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Código',
                'attr' => [
                    'pattern' => '^(\d|\w)+$'
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [ 
                    'minlength' => 2
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Descripción',
            ])
            ->add('status', CheckboxType::class, [
                'label'    => 'Estado',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class
        ]);
    }
}
