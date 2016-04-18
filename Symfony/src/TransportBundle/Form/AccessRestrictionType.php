<?php

namespace TransportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AccessRestrictionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
<<<<<<< HEAD
             ->add('Restriction', EntityType::class, array(
                'class' => 'TransportBundle:AccessRestrictionValue',
                'choice_label' => 'type',  
=======
            ->add('id', TextType::class, array('label' => 'Restriction'))
            ->add('restriction', EntityType::class, array(
                'class' => 'TransportBundle:AccessRestriction',
                'choice_label' => 'accessRestriction',
            ))  
            ->add('save',     SubmitType::class, array('label' => 'Add'))
>>>>>>> b57b4e797ec178e923935b162a74366928dfc18b
            ->getForm();
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TransportBundle\Entity\AccessRestriction'
        ));
    }
}
