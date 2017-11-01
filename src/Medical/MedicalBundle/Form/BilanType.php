<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('referenceBilan', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.ref')))
                ->add('nomBilan', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.name')))
                ->add('descBilan', 'text', array('label' => false, 'attr' => array('class' => 'widthh', 'placeholder' => 'header.menu.prod.desc')))
                ->add('Create', 'submit', array('label' => 'OK', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\MedicalBundle\Entity\Bilan'
        ));
    }
}
