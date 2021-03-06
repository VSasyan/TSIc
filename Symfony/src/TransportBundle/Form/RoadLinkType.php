<?php

namespace TransportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RoadLinkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('centrelineGeometry', HiddenType::class)

            ->add('geographicalName', TextType::class, array('label' => 'Nom'))
            //->add('startNode', RoadNodeType::class, array('label' => 'Noeud de début (facultatif)'))
            //->add('endNode', RoadNodeType::class, array('label' => 'Noeud de fin (facultatif)'))
            ->add('save', SubmitType::class, array('label' => 'Sauver'))

            ->getForm();
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TransportBundle\Entity\RoadLink'
        ));
    }
}
