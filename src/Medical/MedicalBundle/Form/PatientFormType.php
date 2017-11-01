<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PatientFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('cin', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.cinp')))
                ->add('firstname', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width6', 'placeholder' => 'header.menu.profil.fnp')))
                ->add('lastname', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width6', 'placeholder' => 'header.menu.profil.lnp')))
                ->add('sex', 'choice', array('choices' => array(1 => 'men',0 => 'women') , 'attr' => array('class' => 'width4'), 'label' => false))
                ->add('profession', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width8', 'placeholder' => 'header.menu.profil.profp')))
                ->add('month', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.m')))
                ->add('day', 'number', array('required' => false, 'label' => false, 'attr' => array('class' => 'width4', 'placeholder' => '01')))
                ->add('year', 'number', array('required' => false, 'label' => false, 'attr' => array('class' => 'width4', 'placeholder' => '2016')))
                ->add('email', 'email', array('required' => false, 'label' => false, 'attr' => array('class' => 'width7', 'placeholder' => 'header.menu.profil.emp')))
                ->add('tel', 'number', array('required' => false, 'label' => false, 'attr' => array('class' => 'width5', 'placeholder' => 'header.menu.profil.pp')))
                ->add('adress', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.ap')))
                ->add('city', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.cp')))
                ->add('state', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.sp')))
                ->add('code', 'number', array('required' => false, 'label' => false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.codp')))
                ->add('UPDATE', 'submit', array('label' => 'index.head.upgrade', 'attr' => array('class' => 'btn pull-right btn-fullcolor fancybox.ajax')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\MedicalBundle\Entity\User'
        ));
    }

    public function getName() {
        return 'medical_medicalbundle_user_patient';
    }

}
