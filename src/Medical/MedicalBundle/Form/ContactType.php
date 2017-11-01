<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstnameCont','text', array('required' => true,'label' => false, 'attr' => array('class' => 'widtth6', 'placeholder' => 'header.menu.profil.fnp')))
            ->add('lastnameCont','text', array('required' => true,'label' => false, 'attr' => array('class' => 'widtth6', 'placeholder' => 'header.menu.profil.lnp')))
            ->add('emailCont','text', array('required' => true,'label' => false, 'attr' => array('class' => 'widtth12', 'placeholder' => 'header.menu.profil.emp')))
            ->add('subjectCont','text', array('required' => true,'label' => false, 'attr' => array('class' => 'widtth12', 'placeholder' => 'header.menu.profil.subp')))
            ->add('contenuCont','text', array('required' => true,'label' => false, 'attr' => array('class' => 'widtth12', 'placeholder' => 'header.menu.profil.msgp')))
            ->add('Send', 'submit', array('label' => 'header.menu.contact.env', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\MedicalBundle\Entity\Contact'
        ));
    }
}
