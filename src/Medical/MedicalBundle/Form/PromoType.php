<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomPr', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.name')))
                ->add('categoriePr', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.category')))
                ->add('descreptionPr', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.desc')))
                ->add('prixPr', 'number', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.price')))
                ->add('datedebPr', 'date', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.datedp')))
                ->add('datefinPr', 'date', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.datefp')))
                ->add('file', 'file', array('label' => false))
                ->add('Create', 'submit', array('label' => 'OK', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\MedicalBundle\Entity\Promo'
        ));
    }
}
