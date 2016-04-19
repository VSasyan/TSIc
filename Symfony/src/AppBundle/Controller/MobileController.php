<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\TypePerturbation;
use AppBundle\Entity\TypeObjetTerrain;
use AppBundle\Form\MessageType;
use AppBundle\Form\TypePerturbationType;
use AppBundle\Form\TypeObjetTerrainType;
use AppBundle\Repository\MessageRepository;
use AppBundle\Repository\TypePerturbationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MobileController extends Controller {

	/**
	* @Route("/mobile", name="mobile_index")
	*/  
	public function indexAction(){

		return $this->render('AppBundle:Mobile:index.html.twig', array(
			'title' => 'Perturbations à proximité',
			'function' => 'listNearest',
			'nodeJS' => 'listNearest',
		));
	}

	/**
	* @Route("/section/{section}", name="mobile_section", defaults={"section" : "mapNearest"})
	*/  
	public function sectionAction($section){
		$section_list = array(
			'mapNearest' => 'Perturbations à proximité',
			'listNearest' => 'Liste des perturbations à proximité',
			'addPerturbation' => 'Ajouter une nouvelle perturbation',
			'login' => 'Se connecter',
			'Signin' => 'Créer un compte'
		);

		if (!array_key_exists($section, $section_list)) {$section = 'mapNearest';}

		// Generating from template
		$template = $this->container->get('templating')
			->render('AppBundle:Mobile:' . $section . '.html.twig');

		$response = new Response(json_encode(array(
			'title'   => $section_list[$section],
			'html' => $template,
			'section' => $section
		)));
		
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

}


