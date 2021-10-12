<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nom', TextType::class, [
                'required'   => true,
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add(
                'email', EmailType::class, [
                'required'=> true,
                'empty_data'=>'mail@domaine.com',
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add(
                'message', TextareaType::class, [
                'attr' => ['rows' => 6],
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            ]
        );
    }
}
