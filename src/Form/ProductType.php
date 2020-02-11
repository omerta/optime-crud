<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Código',
                'attr' => [
                    'pattern' => '^(\d|\w)+$',
                    'minlength' => 4,
                    'maxlength' => 10
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [ 
                    'minlength' => 4
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Descripción',
            ])
            ->add('brand', TextType::class, [
                'label'    => 'Marca',
                'required' => true,
            ])
            ->add('price', MoneyType::class, [
                'currency' => 'COP',
                'label'    => 'Precio',
                'required' => true,
                'attr' => [
                    'minlength' => 1
                ]
            ])
            ->add('category', EntityType::class, [
                'placeholder' => 'Seleccione...',
                'class'    => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->where('p.status = 1');
                },
            ])
            ->add('save', SubmitType::class,
                ['label' => 'Guardar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class
        ]);
    }
}
