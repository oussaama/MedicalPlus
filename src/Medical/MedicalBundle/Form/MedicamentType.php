<?php

namespace Medical\MedicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicamentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nomMed', 'text', array('label' => false,'attr' => array('class' => 'widthh','placeholder' => 'header.menu.prod.name')))
                ->add('descriptionMed', 'text', array('label' => false,'attr' => array('class' => 'widthh','placeholder' => 'header.menu.prod.desc')))
                ->add('stockMed', 'number', array('label' => false,'attr' => array('class' => 'widthh','placeholder' => 'header.menu.prod.store')))
                ->add('prixMed', 'number', array('label' => false,'attr' => array('class' => 'widthh','placeholder' => 'header.menu.prod.price')))
                ->add('categorieMed','choice', array('choices' => array('header.menu.prod.he' => array('header.menu.prod.bes.b1'=>'header.menu.prod.bes.b1','header.menu.prod.bes.b2'=>'header.menu.prod.bes.b2','header.menu.prod.bes.b3'=>'header.menu.prod.bes.b3','header.menu.prod.bes.b4'=>'header.menu.prod.bes.b4','header.menu.prod.bes.b5'=>'header.menu.prod.bes.b5','header.menu.prod.bes.b6'=>'header.menu.prod.bes.b6'),'header.menu.prod.beu' => array('header.menu.prod.heus.b1'=>'header.menu.prod.heus.b1','header.menu.prod.heus.b2'=>'header.menu.prod.heus.b2','header.menu.prod.heus.b3'=>'header.menu.prod.heus.b3','header.menu.prod.heus.b4'=>'header.menu.prod.heus.b4'),'header.menu.prod.wi' =>array('header.menu.prod.wis.b1'=>'header.menu.prod.wis.b1','header.menu.prod.wis.b2'=>'header.menu.prod.wis.b2','header.menu.prod.wis.b3'=>'header.menu.prod.wis.b3'),'header.menu.prod.wl' => array('header.menu.prod.wls.b1'=>'header.menu.prod.wls.b1','header.menu.prod.wls.b2'=>'header.menu.prod.wls.b2','header.menu.prod.wls.b3'=>'header.menu.prod.wls.b3')),'label' => false,'attr' => array('class' => 'widthh','placeholder' => 'header.menu.prod.category')))
                ->add('file', 'file', array('label' => false))
                ->add('Create', 'submit', array('label' => 'header.menu.profil.create', 'attr' => array('class' => 'btn pull-right btn-fullcolor')));
    }

    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\MedicalBundle\Entity\Medicament'
        ));
    }
}
