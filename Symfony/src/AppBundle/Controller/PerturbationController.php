<?php

namespace AppBundle\Controller;

use SearchBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

// https://github.com/jsor/doctrine-postgis

class PerturbationController extends Controller {


    /**
    * @Route("/perturbation/list/all", name="perturbation_index")
    */  
    public function indexAction(){
        return $this->render('AppBundle:Perturbations:index.html.twig');
    }


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
    * @Route("/perturbation/list/nearest/{position}/{radius}", name="perturbation_list_nearest", defaults={
    *     "position": false,
    *     "radius": 1000
    * })
    */
	public function listNearestAction($position, $radius){

        // Bad position
        if($position == false) {
            return $this->render('AppBundle:Ajax:index.html.twig', array(
                'function' => 'listNearest',
                'title'    => "Liste des perturbations",
            ));
        }

        // For test purpose
		$perturbations = array(
            array(
                'id' => 1,
                'name' => 'Coucou',
                'center' => 'center',
                'type' => array('logo' => 'logo')
            )
		);

        // Generating from template
        $template = $this->container->get('templating')->render(
            'AppBundle:Perturbation:listNearest.html.twig', array('perturbations' => $perturbations));

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
	public function addAction(){

		return new Response('<html><body>Salut!</body></html>');

	}

	/**
    * @Route("/perturbation/vote/{id_perturbation}/{id_message}", name="perturbation_vote")
    */
	public function voteAction(){

		return new Response('<html><body>Salut!</body></html>');
		
	}

    /**
    * @Route("/perturbation/show/{id}", name="perturbation_show")
    */

	public function showAction($id){

        $perturbation = array(
            'id' => 1,
            'creation_date' => '5/04/2016',
            'valid' => true,
            'formulations' => array(array(
                'name' => 'coucou',
                'center' => 'center',
                'type' => array(
                    'name' => 'Type',
                    'logo' => 'logo',
                    'description' => 'Coucou type'
                ),
                'creation_date' => '16:18',
                'begin_date' => '16:20',
                'end_date' => '16:21'
            ))
        );

        return $this->render('AppBundle:Perturbation:show.html.twig', array('perturbation' => $perturbation));
		
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


