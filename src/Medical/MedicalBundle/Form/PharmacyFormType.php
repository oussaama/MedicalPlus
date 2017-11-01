<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PharmacyFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('entrepriseName', 'text', array('required' => false,'label'=>false,  'attr' => array('class' => 'width6', 'placeholder' => 'header.menu.profil.entp')))
                ->add('assurance', 'text', array('required' => false,'label'=>false,  'attr' => array('class' => 'width6', 'placeholder' => 'CNSS,CNAM,.....')))
                ->add('tel', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.pp')))
                ->add('email', 'text', array('required' => false, 'label' => false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.emp')))
                ->add('adress', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width12', 'placeholder' => 'header.menu.profil.ap')))
                ->add('city', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.cp')))
                ->add('state', 'text', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.sp')))
                ->add('code', 'number', array('required' => false,'label'=>false, 'attr' => array('class' => 'width4', 'placeholder' => 'header.menu.profil.zp')))
                ->add('UPDATE', 'submit', array('label' => 'index.head.upgrade', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
                
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
        return 'medical_medicalbundle_user_pharmacy';
    }

}
