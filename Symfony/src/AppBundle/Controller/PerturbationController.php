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
            'function' => 'listNearest'
        ));

    }


    /**
    * @Route("/perturbation/list/all", name="perturbation_list_all")
    */  
    public function listAllAction(){

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Perturbation');
        $perturbations = $repository->findAll();

        if (!$perturbations){
            throw $this->createNotFoundException(
                'No perturbations '
            );
        }
        else
        {

	        foreach ($perturbations as $p) {
	        	$virtualPerturbation = $p->returnVirtualPerturbation();
	        	if ($virtualPerturbation != false) {
	        		echo "OK";
	        		$virtualPerturbations[] = $virtualPerturbation;
	        	}
	        }

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
                'title'    => "Liste des perturbations",
            ));
        }

		//example
		$position = "ST_GeomFromText('" . $position . "',4326)";
		/*$position = "ST_GeomFromText('POINT(-72.1235 42.3521)',4326)";*/

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Formulation');

        $perturbations = $repository->findNearest($position, $radius);
        //$perturbations = array();
        $virtualPerturbations = array();
        foreach ($perturbations as $p) {
        	$virtualPerturbation = $p->returnVirtualPerturbation();
        	if ($virtualPerturbation != false) {
        		$virtualPerturbations[] = $virtualPerturbation;
        	}
        }
        
  //       // For test purpose
		// $perturbations = array(
  //           array(
  //               'id' => 1,
  //               'name' => 'Coucou',
  //               'center' => 'center',
  //               'type' => array('logo' => 'logo')
  //           )
		// );

		//$formulations = returnLastFormulation($perturbations);

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
        $form = $this->createForm(FormulationType::class, $formulation);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$formulation->setCenter(\ST_GeomFromText($formulation->getCenter(),4326));
            //$formulation->setCenter(\ST_GeomFromText('POINT(-72.1235 42.3521)',4326));
            //$formulation->setCenter('SRID=4326;POINT(37.4220761 -122.0845187)');
            $formulation->setCreationDate(new \DateTime);
            $formulation->setValidFormulation(true);
            //"ST_GeomFromText('POINT(-72.1235 42.3521)',4326)"
            // Ajout des liens perturbation user formulation :
            $perturbation = new Perturbation();
            $perturbation->addFormulation($formulation);
            //$this->getUser()->addFormulation($formulation);
            //modification en cascade?
            //$em->persist($this->getUser());
            $em->persist($perturbation);
            $em->persist($formulation);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'Perturbation bien enregistrée.');

            return $this->redirect($this->generateUrl('perturbation_show', array('id' => $perturbation->getId())));
        }
        return $this->render('AppBundle:Perturbation:add.html.twig', array('form' => $form->createView(), 'title' => ''));
	}

	/**
    * @Route("/perturbation/vote/{id_perturbation}/{id_message}", name="perturbation_vote")
    */
	public function voteAction($id_perturbation, $id_message){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id_perturbation);

		switch ($id_message) {
		    case 1:
		    	//perturbation incorrecte
		    	$perturbation->setActivated(false);
		    	$em->flush();
		    	//on redirige vers la liste de toutes les perturbations 
		    	return $this->redirect($this->generateUrl('perturbation_list_all'));
		        break;
		    case 2:
		    	//l'événement a bien eu lieu mais est terminé
		    	$perturbation->setActivated(false);
		    	$perturbation->setValidated(true);
		    	$em->flush();
		    	//on redirige vers la route d'archivage
		 		return $this->redirect($this->generateUrl('perturbation_archive', array('id' => $perturbation->getId())));   	
		        break;
		    case 3:
		    	//validation, l'évènement a bien lieu
		    	$perturbation->setActivated(true);
		    	$perturbation->setValidated(true);
		    	$em->flush();
		    	//on redirige vers la liste de toutes les perturbations 
		    	return $this->redirect($this->generateUrl('perturbation_list_all'));
		        break;
		    default:
		    	//on redirige vers la liste de toutes les perturbations 
		    	return $this->redirect($this->generateUrl('perturbation_list_all'));
		        break;
		}
	
	}

    /**
    * @Route("/perturbation/show/{id}", name="perturbation_show")
    */
	public function showAction($id){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id);

/*
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
*/
        if ($perturbation)
        {
        	//si on trouve la perturbation, on la montre
	        return $this->render('AppBundle:Perturbation:show.html.twig', array('perturbation' => $perturbation));
        }
        else
        {
        	//si on ne trouve pas la perturbation, on retourne vers la vue index
        	return $this->render('AppBundle:Ajax:index.html.twig', array(
        			'function' => 'listNearest',
        			'title'    => "Liste des perturbations"
        		));
        	
        }
	}

	/**
    * @Route("/perturbation/archive/{id}}", name="perturbation_archive")
    */
	public function archiveAction($id){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbations')->find($id);
		$perturbation->setArchived(true);

		$em->flush();

		//retourne vers la liste des évènements archivés
        return $this->redirect($this->generateUrl('perturbation_show', array('id' => $perturbation->getId())));
	}

	/**
    * @Route("/perturbation/edit/{id}", name="perturbation_edit")
    */
	public function editAction($id, Request $request){

		//nouvelle formulation
		$formulation = new Formulation();
        //on récupère le formulaire associé à la nouvelle perturbation
        $form = $this->createForm(FormulationType::class, $formulation);

        //si le formulaire est correct
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //on récupère l'entity associée à l'id
    		$perturbation = $this->getDoctrine()
    		  ->getManager()
    		  ->getRepository('AppBundle:Perturbation')
    		  ->find($id)
    		;

    		//récupérer tous les anciennes formulations des perturbations et les mettre à false
    		$formulations = $perturbation->getFormulations();
    		foreach ($formulations as $formulation) {
      			$formulation->setValid_formulation(false);
		    }

		    //ajout des liens
            $perturbation->addFormulation($formulation);
            $this->getUser()->addFormulation($formulation);
            //modification en cascade?
            //pas besoin de persister les données qui juste été modifiées
            //$em->persist($this->getUser());
            //$em->persist($perturbation);
            $em->persist($formulation);
            $em->flush();
            
            //affichage message d'info
            $request->getSession()->getFlashBag()->add('info', 'Perturbation bien enregistrée.');

            //on retourne vers la route de vue de la perturbation
            return $this->redirect($this->generateUrl('perturbation_show', array('id' => $perturbation->getId())));
        }
        //si le formulaire n'est pas valide, on revient à la vue de siasie du formulaire
        return $this->render('AppBundle:Pertubation:add.html.twig', array('form' => $form->createView()));
		
	}



}


