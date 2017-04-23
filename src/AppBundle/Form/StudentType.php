<?php

namespace AppBundle\Form;

use AppBundle\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('placeOfBirth', TextType::class)
            ->add('dateOfBirth', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('sex',ChoiceType::class, [
                'choices' => [
                    'male' => 'male',
                    'female' => 'female',
                ]
            ])
            ->add('studyGroups', EntityType::class,[
            'class' => 'AppBundle\Entity\StudyGroup',
            'choice_label' => 'name',
            'expanded' => true,// checkboxes will be rendered
            'multiple'=> true,
            'by_reference' => false// by_reference must be set to false if you need the adder and remover to be called.


            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Student::class]);
    }

}
