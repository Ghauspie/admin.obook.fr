<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Team;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isValid')
            ->add(
                'user', EntityType::class, [
                'label' => 'Quel est l\'utilisateur que vous souhaitez ajouter au projet :',
                'class' => User::class,
                'choice_label' => 'FLname',
                'multiple'=>false,
                'expanded'=>false,
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add(
                'project',
                EntityType::class,
                [
                'label' => 'Sur quel projet il a travaillé :',
                'class' => Project::class,
                'choice_label' => 'name',
                'multiple'=>false,
                'expanded'=>false,
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
            'data_class' => Team::class,
            ]
        );
    }
}
