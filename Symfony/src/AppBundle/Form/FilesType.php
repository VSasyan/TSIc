<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilesType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class, array('label' => 'Nom', 'required' => true))
			->add('type', ChoiceType::class, array(
				'choices' => array(
					'Image' => 'jpg,jpeg,gif,png',
					'Fichier audio' => 'mp3,wma',
					'Document' => 'pdf'
				),
				'required' => true
			))
			->add('fileFile', FileType::class, array('label' => 'Fichier', 'required' => true))
			->add('save', SubmitType::class, array('label' => 'Sauver'))
			->getForm();
	}
	
	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\File'
		));
	}
}
