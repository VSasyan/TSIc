<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FormulationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('type', EntityType::class, array(
                'class' => 'AppBundle:TypePerturbation',
                'choice_label' => 'name',
            ))
            ->add('description', TextareaType::class, array('label' => 'Description'))
            //->add('center')
            ->add('geoJSON')
            ->add('beginDate', DateTimeType::class, array('label' => 'Début'))
            ->add('endDate', DateTimeType::class, array('label' => 'Fin estimée'))
            //->add('type')
            ->add('save', SubmitType::class, array('label' => 'Sauver'))
            ->getForm();
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
