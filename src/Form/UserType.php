<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Spe;
use App\Entity\Techno;
use App\Entity\Contrat;
use App\Repository\SpeRepository;
use App\Repository\TechnoRepository;
use App\Repository\ContratRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add(
                'firstname', TextType::class, [
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add(
                'lastname', TextType::class, [
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add(
                'email', EmailType::class, [
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add(
                'story', TextareaType::class, [
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add('is_search_job')

            ->add(
                'roles', ChoiceType::class, [
                'required' => true,
     
                'choices'=>[
                    'select'=>null,
                    'Administrateur'=> 'ROLE_ADMIN',
                    'Utilisateur'=>'ROLE_USER',
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Rôles' 

                ]
            )
           ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) 
           {
                // ... adding the name field if needed
                $user= $event->getData();
                $form =$event->getForm();
                if ($_SERVER['REQUEST_URI']=="/user/new")
                {
                    $form->add('password', PasswordType::class,
                    [
                    'attr'=> 
                        [
                        'placeholder'=> 'Description de l\'Apotheose',
                        'class'=>'form-control'
                        ],
                        ]
                );
               };
            })
        
            
            ->add(
                'picture', UrlType::class, [
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ]
            )
            ->add(
                'spe', EntityType::class,

                [
                'label' => 'Quel est la spe',
                'class' => Spe::class,
                'choice_label' => 'name',
                'attr'=> [
                    'placeholder'=> 'Description de l\'Apotheose',
                    'class'=>'form-control'
                ]
                ],
            )
            ->add(
                'technos', EntityType::class, [
                'label' => 'Quelle est la techno que l\'utilisateur connait :',
                'class' => Techno::class,
                'choice_label' => 'name',
                'multiple'=>true,
                'expanded'=>true,
                ]
            )
            ->add(
                'contrats', EntityType::class, [
                'label' => 'Quelle est le type de contrat que l\'utilisateur souhaite :',
                'class' => Contrat::class,
                'choice_label' => 'name',
                'multiple'=>true,
                'expanded'=>true,
                ]
            );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            'data_class' => User::class,
            ]
        );
    }
}
