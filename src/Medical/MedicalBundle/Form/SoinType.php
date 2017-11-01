<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoinType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nom_soin', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.name')))
                ->add('description_soin', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.desc')))
                ->add('prix_soin', 'number', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.price')))
                ->add('type_soin', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.typep')))
                ->add('file', 'file', array('label' => false))
                ->add('Create', 'submit', array('label' => 'header.menu.profil.create', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\MedicalBundle\Entity\Soin'
        ));
    }

}
