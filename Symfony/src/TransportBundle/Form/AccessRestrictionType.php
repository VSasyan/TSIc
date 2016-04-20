<?php

namespace TransportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AccessRestrictionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('validfrom', DateTimeType::class, array('label' => 'valid from'))
            ->add('validto', DateTimeType::class, array('label' => 'valid to'))
            ->add('beginlifespanversion', DateTimeType::class, array('label' => 'begin life span version'))
            ->add('endlifespanversion', DateTimeType::class, array('label' => 'end life span version'))
            ->add('restriction', EntityType::class, array(
                'class' => 'TransportBundle:AccessRestrictionValue',
                'choice_label' => 'name',
            ))
            ->add('save',     SubmitType::class, array('label' => 'Add'))
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
