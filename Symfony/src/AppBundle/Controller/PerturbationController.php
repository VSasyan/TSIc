<?php

namespace AppBundle\Controller;

use SearchBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PerturbationController extends StatutController {


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
        return $this->render('AppBundle:Perturbations:show.html.twig', $perturbations); 

    }

	/**
    * @Route("/perturbation/list/nearest/{position}/{rayon}", name="perturbation_list_nearest")
    */
	public function listNearestAction($position, $rayon = 1000){

		$perturbations = array(
            array(
                'id' => 1,
                'name' => 'Coucou',
                'center' => 'center',
                'type' => array('logo' => 'logo')
            )
		);

		return $this->render('AppBundle:Perturbation:listNearest.html.twig', array('perturbations' => $perturbations));

	}

	/**
    * @Route("/perturbation/add", name="perturbation_add")
    */
	public function addAction(Request $request){

		$formulation = new Formulation();
        $form = $this->get('form.factory')->create(new FormulationType, $formulation);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Ajout du lien societe - artisan :
            $perturbation = new Perturbation();
            $perturbation->addFormulation($formulation);
            $this->getUser()->addFormulation($formulation);
            //modification en cascade?
            $em->persist($this->getUser());
            $em->persist($perturbation);
            $em->persist($formulation);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'Perturbation bien enregistrée.');

            return $this->redirect($this->generateUrl('perturbation_show', array('id' => $perturbation->getId())));
        }
        return $this->render('AppBundle:Pertubation:add.html.twig', array('form' => $form->createView()));
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

	public function archiveAction($id){

		$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Perturbations');
		$perturbation = $repository->findById($id);
		$perturbation->setArchived(true);

		return new Response('<html><body>action archivée</body></html>');
	}

	/**
    * @Route("/perturbation/edit/{id}", name="perturbation_edit")
    */
	public function editAction($id, Request $request){


		return new Response('<html><body>Salut!</body></html>');
		
	}



}


