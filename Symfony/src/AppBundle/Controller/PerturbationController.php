<?php

namespace AppBundle\Controller;

use SearchBundle\Entity\Particulier;
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
            'title' => '',
            'function' => ''
        ));
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
    *     "position" : false,
    *     "radius": 1000
    * })
    */
	public function listNearestAction($position, $radius){

		//example
		$position = "ST_GeomFromText('POINT(-72.1235 42.3521)',4326)";

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Formulation');

        $perturbations = $repository->findNearest($position, $rayon);

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
	public function addAction(Request $request){

		$formulation = new Formulation();
        $form = $this->createForm(FormulationType::class, $user);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Ajout des liens perturbation user formulation :
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
	public function voteAction($id_perturbation, $id_message){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbations')->find($id_perturbation);

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

        $perturbation = array(
            'id' => 1,
            'creationDate' => '5/04/2016',
            'valid' => true,
            'formulations' => array(array(
                'name' => 'coucou',
                'center' => 'center',
                'type' => array(
                    'name' => 'Type',
                    'logo' => 'logo',
                    'description' => 'Coucou type'
                ),
                'creationDate' => '16:18',
                'beginDate' => '16:20',
                'endDate' => '16:21',
                'description' => 'A very lengthy text lorem ipsum et cætera',
            ))
        );

        return $this->render('AppBundle:Perturbation:show.html.twig', array('perturbation' => $perturbation));
		
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


