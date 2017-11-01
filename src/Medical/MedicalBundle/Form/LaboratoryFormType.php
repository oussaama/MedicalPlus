<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LaboratoryFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('entrepriseName', 'text', array('required' => false,'label'=>false,  'attr' => array('class' => 'width6', 'placeholder' => 'header.menu.profil.entp')))
                ->add('assurance', 'text', array('required' => false,'label'=>false,  'attr' => array('class' => 'width6', 'placeholder' => 'CNSS,CNAM,.....')))
                ->add('tel', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.pp')))
                ->add('email', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.emp')))
                ->add('adress', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.ap')))
                ->add('city', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.cp')))
                ->add('state', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.sp')))
                ->add('code', 'number', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.codp')))
                ->add('UPDATE', 'submit', array('label' => 'index.head.upgrade', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
                
    }

    public function getName() {
        return 'medical_medicalbundle_Laboratory';
    }

}
