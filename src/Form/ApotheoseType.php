<?php

namespace App\Form;

use App\Entity\Apotheose;
use App\Entity\UrlApotheose;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApotheoseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'promo', TextType::class, [
                'attr'=> [
                    'placeholder'=> 'Nom de la promo',
                    'class'=>'form-control'
                ]
                ]
            )

            ->add(
                'description', TextareaType::class, [
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add('is_publish')
            ->add(
                'urlapotheose', EntityType::class, [
                'label' => 'Quelle est l\'url lié a cette apothéose : ',
                'class' => UrlApotheose::class,
                'choice_label' => 'url',
                'multiple'=>true,
                'expanded'=>false,
                 ]
            ); 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            'data_class' => Apotheose::class,
            ]
        );
    }
}
