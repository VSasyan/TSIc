<?php

namespace TransportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class WeatherConditionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('validfrom', DateTimeType::class, array('label' => 'Début'))
            ->add('validto', DateTimeType::class, array('label' => 'Fin'))
            ->add('beginlifespanversion', DateTimeType::class, array('label' => 'Début'))
            ->add('endlifespanversion', DateTimeType::class, array('label' => 'Fin'))
            ->add('weatherConditionValue', EntityType::class, array(
                'class' => 'TransportBundle:WeatherConditionValue',
                'choice_label' => 'name'
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
            'data_class' => 'TransportBundle\Entity\WeatherCondition'
        ));
    }
}
