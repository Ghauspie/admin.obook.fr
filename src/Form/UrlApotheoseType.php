<?php

namespace App\Form;

use App\Entity\Apotheose;
use App\Entity\UrlApotheose;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UrlApotheoseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'url', UrlType::class, [
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
        /*             ->add('apotheose', EntityType::class, [
                'class'=>Apotheose::class,
                'choice_label' => 'promo',
                'multiple'=>false,
                'expanded'=>true,
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            'data_class' => UrlApotheose::class,
            ]
        );
    }
}
