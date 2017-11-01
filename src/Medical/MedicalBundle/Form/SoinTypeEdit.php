<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoinTypeEdit extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nom_soin', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.name')))
                ->add('description_soin', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.desc')))
                ->add('prix_soin', 'number', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.price')))
                ->add('type_soin', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.typep')))
                ->add('Create', 'submit', array('label' => 'index.head.upgrade', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
    }

}
