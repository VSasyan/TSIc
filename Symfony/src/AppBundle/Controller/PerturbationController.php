<?php

namespace AppBundle\Controller;

use SearchBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PerturbationController extends Controller {


	/**
    * @Route("/perturbation/list/all", name="perturbation_list_all")
    */	
	public function listAllAction(){

		$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Perturbations');
		$perturbations = $repository->findAll();

		if (!perturbations){
			throw $this->createNotFoundException(
        	    'No perturbations '
        	);

		}

		return $this->render('AppBundle:Perturbations:show.html.twig', $perturbations); 

	}

	/**
    * @Route("/perturbation/list/nearest/{position}", name="perturbation_list_nearest")
    */
	public function listNearestAction($position){

		return $this->render('AppBundle:Perturbation:show.html.twig', array('position' => $position));

	}

	/**
    * @Route("/perturbation/add", name="perturbation_add")
    */

	public function addAction(){

		return new Response('<html><body>Salut!</body></html>');

	}

	/**
    * @Route("/perturbation/vote/{id_perturbation}/{id_vote}", name="perturbation_vote")
    */

	public function voteAction(){

		return new Response('<html><body>Salut!</body></html>');
		
	}

	/**
    * @Route("/perturbation/archive/{id}}", name="perturbation_archive")
    */

	public function archiveAction(){

		return new Response('<html><body>Salut!</body></html>');
		
	}

	/**
    * @Route("/perturbation/edit/{id}}", name="perturbation_edit")
    */

	public function editAction($id){

		return new Response('<html><body>Salut!</body></html>');
		
	}



}

