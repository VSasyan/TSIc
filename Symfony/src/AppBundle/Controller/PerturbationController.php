<?php

namespace AppBundle\Controller;

use SearchBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PerturbationController extends StatutController {


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

		//order by ?
	    // public function findAll()
    	// {
     //    	return $this->findBy(array(), array('date' => 'ASC'));
    	// }

		return $this->render('AppBundle:Perturbations:show.html.twig', $perturbations); 

	}

	/**
    * @Route("/perturbation/list/nearest/{position}", name="perturbation_list_nearest")
    */
	public function listNearestAction($position){

		$perturbations = array(
			'name' => 'Coucou',
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
    * @Route("/perturbation/vote/{id_perturbation}/{id_vote}", name="perturbation_vote")
    */
	public function voteAction(){

		return new Response('<html><body>Salut!</body></html>');
		
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


