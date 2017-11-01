<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AppointmentFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('cin_rv', 'number', array('required' => true, 'label' => false, 'attr' => array('class' => 'sm-width12', 'placeholder' => 'header.menu.profil.cinp')))
                ->add('firstname_rv', 'text', array('required' => true,'label' => false, 'attr' => array('class' => 'sm-width6', 'placeholder' => 'header.menu.profil.fnp')))
                ->add('lastname_rv', 'text', array('required' => true,'label' => false, 'attr' => array('class' => 'sm-width6', 'placeholder' => 'header.menu.profil.lnp')))
                ->add('heure_rv', 'choice', array('required' => true,'choices' => array(9=>'9',10 =>'10',11=>'11',12=>'12',14=>'14',15=>'15',16=>'16',17=>'17'),'label' => false, 'attr' => array('class' => 'sm-width6', 'placeholder' => '17')))
                ->add('minute_rv', 'choice', array('required' => true,'choices' => array(0=>'00',30 =>'30'),'label' => false, 'attr' => array('class' => 'sm-width6', 'placeholder' => '00')))
                ->add('tel_rv', 'number', array('required' => true,'label' => false, 'attr' => array('class' => 'sm-width6', 'placeholder' => 'header.menu.profil.pp')))
                ->add('email_rv', 'email', array('required' => true,'label' => false, 'attr' => array('class' => 'sm-width6', 'placeholder' => 'header.menu.profil.emp')))
                ->add('BOOK', 'submit', array('label' => 'header.menu.profil.book', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
    }

    public function getName() {
        return 'medical_medicalbundle_appointment';
    }

}
