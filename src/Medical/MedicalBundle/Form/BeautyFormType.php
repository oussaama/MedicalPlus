<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BeautyFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('cin', 'number', array('required' => false,'label'=>false,  'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.cinp')))
                ->add('username', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width7', 'placeholder' => 'header.menu.profil.userp')))
                ->add('tel', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width5', 'placeholder' => 'header.menu.profil.pp')))
                ->add('speciality','choice',array('choices' => array('md' => 'centre.md','cd'=>'centre.cd','k'=>'centre.k','i'=>'centre.i','orth'=>'centre.orth','op'=>'centre.op','di'=>'centre.di'),'required' => false,'label'=>false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.specp')))
                ->add('email', 'email', array('required' => false,'label'=>false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.emp')))
                ->add('adress', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width12', 'placeholder' => 'Please enter your adress')))
                ->add('city', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.cp')))
                ->add('state', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.sp')))
                ->add('code', 'number', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.codp')))
                ->add('UPDATE', 'submit', array('label' => 'index.head.upgrade', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
                
    }

    public function getName() {
        return 'medical_medicalbundle_pharmacy';
    }

}
