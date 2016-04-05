<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description'))
            //->add('center')
            //->add('geoJSON')
            -//>add('creationDate', 'datetime')
            ->add('beginDate', 'datetime', array('label' => 'Début'))
            ->add('endDate', 'datetime', array('label' => 'Fin estimée'))
            //->add('type')
            ->add('save', 'submit', array('label' => 'Sauver'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Formulation'
        ));
    }
}
