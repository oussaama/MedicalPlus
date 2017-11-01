<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AppointmentFormTypeEdit extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('cin_rv', 'number', array('required' => true, 'label' => false, 'attr' => array('class' => 'app-width-1', 'placeholder' => 'header.menu.profil.cinp')))
                ->add('firstname_rv', 'text', array('required' => true,'label' => false, 'attr' => array('class' => 'app-width-2', 'placeholder' => 'header.menu.profil.fnp')))
                ->add('lastname_rv', 'text', array('required' => true,'label' => false, 'attr' => array('class' => 'app-width-2', 'placeholder' => 'header.menu.profil.lnp')))
                ->add('heure_rv', 'choice', array('required' => true,'choices' => array(9=>'9',10 =>'10',11=>'11',12=>'12',14=>'14',15=>'15',16=>'16',17=>'17'),'label' => false, 'attr' => array('class' => 'app-width-2', 'placeholder' => '17')))
                ->add('minute_rv', 'choice', array('required' => true,'choices' => array(0=>'00',30 =>'30'),'label' => false, 'attr' => array('class' => 'app-width-2', 'placeholder' => '00')))
                ->add('date_rv', 'text', array('required' => true,'label' => false, 'attr' => array('class' => 'app-width-1', 'placeholder' => '25/05/2016')))
                ->add('tel_rv', 'number', array('required' => true,'label' => false, 'attr' => array('class' => 'app-width-2', 'placeholder' => 'header.menu.profil.pp')))
                ->add('email_rv', 'email', array('required' => true,'label' => false, 'attr' => array('class' => 'app-width-2', 'placeholder' => 'header.menu.profil.emp')))
                ->add('BOOK', 'submit', array('label' => 'index.head.upgrade', 'attr' => array('class' => 'btn btn-primary btn-pull-right buttun')));
    }

    public function getName() {
        return 'medical_medicalbundle_appointment_edit';
    }

}
