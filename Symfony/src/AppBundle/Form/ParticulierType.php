<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParticulierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',     TextType::class,     array('label' => 'Nom'))
            ->add('lastname', TextType::class,     array('label' => 'Prénom'))
            ->add('username', TextType::class,     array('label' => 'Utilisateur'))  
            ->add('password', PasswordType::class, array('label' => 'Mot de passe'))
            ->add('email',    EmailType::class,    array('label' => 'Email'))
            ->add('save',     SubmitType::class,   array('label' => 'sauver'))
            ->getForm();
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Particulier'
        ));
    }
}
