<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin')
            ->add('adress')
            ->add('city')
            ->add('state')
            ->add('code')
            ->add('class')
            ->add('picture')
            ->add('firstName')
            ->add('lastName')
            ->add('day')
            ->add('year')
            ->add('month')
            ->add('profession')
            ->add('sex')
            ->add('tel')
            ->add('speciality')
            ->add('role')
            ->add('entrepriseName')
            ->add('nombre')
            ->add('assurance')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\MedicalBundle\Entity\User'
        ));
    }
}
