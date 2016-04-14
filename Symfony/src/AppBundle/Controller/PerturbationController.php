<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Particulier;
use AppBundle\Entity\Perturbation;
use AppBundle\Entity\Formulation;
use AppBundle\Form\FormulationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PerturbationController extends StatutController {


	/**
	* @Route("/perturbation/list", name="perturbation_index")
	*/  
	public function indexAction(){

		return $this->render('AppBundle:Ajax:index.html.twig', array(
			'title' => 'Perturbations à proximité',
			'function' => 'listNearest',
			'nodeJS' => 'listNearest',
		));

	}

	/**
	* @Route("/perturbation/list/all", name="perturbation_list_all")
	*/  
	public function listAllAction(){

		$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Perturbation');
		$perturbations = $repository->findAll();

		foreach ($perturbations as $p) {
				$virtualPerturbations[] = $p->returnVirtualPerturbation();
		}

		return $this->render('AppBundle:Perturbation:listAll.html.twig', array(
		   'perturbations' => $virtualPerturbations,
		   'title'    => "Liste des perturbations",
		));
		
	}

	/**
	* @Route("/perturbation/list/nearest/{position}/{radius}", name="perturbation_list_nearest", defaults={
	*	  "position" : false,
	*     "radius": 1000
	* })
	*/
	public function listNearestAction($position, $radius){

		// Bad position
		if($position == false) {
			return $this->render('AppBundle:Ajax:index.html.twig', array(
				'function' => 'listNearest',
				'title'    => "Perturbations à proximité",
			));
		}

		//example
		$position = "ST_GeomFromText('" . $position . "',4326)";
		/*$position = "ST_GeomFromText('POINT(-72.1235 42.3521)',4326)";*/

		$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Perturbation');
		$perturbations = $repository->findNearest($position, $radius);


		$virtualPerturbations = array();
		foreach ($perturbations as $p) {
			$virtualPerturbation = $p->returnVirtualPerturbation();
			if ($virtualPerturbation != false) {
				$virtualPerturbations[] = $virtualPerturbation;
			}
		}

		// Generating from template
		$template = $this->container->get('templating')->render(
			'AppBundle:Perturbation:listNearest.html.twig', array('perturbations' => $virtualPerturbations));

		$response = new Response(json_encode(array(
			'title'   => "Liste des perturbations",
			'content' => $template,
		)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;

	}

	/**
	* @Route("/perturbation/add", name="perturbation_add")
	*/
	public function addAction(Request $request){

		$formulation = new Formulation();
		// Gestion date dans le formulaire
		$formulation->setBeginDate(new \DateTime());
		$end = new \DateTime();
		$end->add(new \DateInterval ("PT2H"));
		$formulation->setEndDate($end);
		
		$form = $this->createForm(FormulationType::class, $formulation);

		if ($form->handleRequest($request)->isValid()) {

			$em = $this->getDoctrine()->getManager();
			$formulation->setCreationDate(new \DateTime);
			$formulation->setValidFormulation(true);
			$perturbation = new Perturbation();
			$perturbation->addFormulation($formulation);
			$this->getUser()->addFormulation($formulation);
			$this->getUser()->addPerturbation($perturbation);

			$em->persist($this->getUser());
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Perturbation bien enregistrée.');

			return $this->redirect($this->generateUrl('perturbation_show', array('id' => $perturbation->getId())));
		}

		return $this->render('AppBundle:Perturbation:add.html.twig', array('form' => $form->createView()));
	}

	

	/**
	* @Route("/perturbation/show/{id}", name="perturbation_show")
	*/
	public function showAction($id){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id);

		if ($perturbation != null) {
			return $this->render('AppBundle:Perturbation:show.html.twig', array('perturbation' => $perturbation));
		} else {
			//si on ne trouve pas la perturbation, on retourne vers la vue index
			return $this->render('AppBundle:Ajax:index.html.twig', array(
				'function' => 'listNearest',
				'title'    => "Liste des perturbations"
			));
		}
	}

	/**
	* @Route("/pro/perturbation/archive/{id}", name="perturbation_archive")
	*/
	public function archiveAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id);
		$perturbation->setArchived(true);

		$em->flush();

		$request->getSession()->getFlashBag()->add('success', 'Perturbation archivée avec succès.');

		//retourne vers la liste des évènements archivés
		return $this->render('AppBundle:Ajax:confirmation.html.twig');
	}

	/**
	* @Route("/professionnel/perturbation/edit/{id}", name="perturbation_edit")
	*/
	public function editAction($id, Request $request){

		$em = $this->getDoctrine()->getManager();
		$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id);

		if ($perturbation != null) {

			$formulation = $perturbation->getLastFormulation();
			$form = $this->createForm(FormulationType::class, $formulation);
			$formulation_new = new Formulation;
			$form_new = $this->createForm(FormulationType::class, $formulation_new);

			if ($form_new->handleRequest($request)->isValid()) {

				$perturbation->addFormulation($formulation_new);
				$this->getUser()->addFormulation($formulation_new);

				$em->persist($formulation_new);
				$em->flush();
				
				$request->getSession()->getFlashBag()->add('success', 'Perturbation bien modifiée.');

				return $this->redirect($this->generateUrl('perturbation_show', array('id' => $id)));
			}

		}

		return $this->render('AppBundle:Perturbation:edit.html.twig', array('form' => $form->createView()));
		
	}



}


