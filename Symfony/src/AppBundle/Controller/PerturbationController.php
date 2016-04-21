<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Particulier;
use AppBundle\Entity\Perturbation;
use AppBundle\Entity\PerturbationFile;
use AppBundle\Entity\Formulation;
use AppBundle\Entity\File;
use AppBundle\Form\FilesType;
use AppBundle\Form\FormulationType;
use AppBundle\Form\PerturbationFileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ElephantIO\Client, ElephantIO\Engine\SocketIO\Version1X; 

require '../vendor/autoload.php';

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

		return $this->render('AppBundle:Perturbation:listAll.html.twig', array(
		   'perturbations' => $perturbations,
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

		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Perturbation');

		// Terminate old perturbations :
		$olds = $repository->findOld();
		if (count($olds) > 0) {
			foreach ($olds as $p) {$p->setTerminated(true);}
			$em->flush();
		}
		
		if($position == false) {return $this->redirect($this->generateUrl('perturbation_index'));}

		$position = "ST_GeomFromText('" . $position . "',4326)";

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
	* @Route("/perturbation/list/nearest-ajax/{position}/{radius}", name="ajax_perturbation_list_nearest", defaults={
	*	  "position" : false,
	*     "radius": 1000
	* })
	*/
	public function listNearestAjaxAction($position, $radius){

		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('AppBundle:Perturbation');

		// Terminate old perturbations :
		$olds = $repository->findOld();
		if (count($olds) > 0) {
			foreach ($olds as $p) {$p->setTerminated(true);}
			$em->flush();
		}
		
		if($position == false) {return $this->redirect($this->generateUrl('perturbation_index'));}

		$position = "ST_GeomFromText('" . $position . "',4326)";

		$perturbations = $repository->findNearest($position, $radius);

		$virtualPerturbations = array();
		foreach ($perturbations as $p) {
			$f = $p->getLastFormulation();
			if (is_a($f->getType(), 'AppBundle\Entity\TypePerturbation')) {
				$virtualPerturbations[] = array(
					'id' => $p->getId(),
					'name' => $f->getName(),
					'geometry' => $f->getCenter(),
					'type' => $f->getType()->getId(),
					'type_name' => $f->getType()->getName()
				);
			} else {
				$virtualPerturbations[] = array(
					'id' => $p->getId(),
					'name' => $f->getName(),
					'geometry' => $f->getCenter(),
					'type' => 0,
					'type_name' => $f->getFreeType()
				);
			}
		}

		$response = new Response(json_encode($virtualPerturbations));
		
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
			$perturbation = new Perturbation();
			$perturbation->addFormulation($formulation);
			$this->getCurrentUser()->addFormulation($formulation);
			$this->getCurrentUser()->addPerturbation($perturbation);

			$em->persist($this->getCurrentUser());
			$em->flush();

			//initialisation de elephant.io
			$client = new Client(new Version1X('http://localhost:8080'));
			$client ->initialize();

			$request->getSession()->getFlashBag()->add('notice', 'Nouvelle perturbation chargée.');
			$template = $this->container->get('templating')->render('AppBundle:Ajax:confirmation.html.twig');

			$client ->emit('emitPHP', [
				'message' => $template,
				'coordinates' => $formulation->getCenter()
			]);
			$client ->close();
			
			$request->getSession()->getFlashBag()->add('success', 'Perturbation bien enregistrée.');

			return $this->redirect($this->generateUrl('perturbation_list_nearest'));
		}

		return $this->render('AppBundle:Perturbation:add.html.twig', array('form' => $form->createView()));
	}

	/**
	* @Route("/perturbation/add/redis", name="perturbation_add_redis")
	*/
	public function addRedisAction(Request $request){

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
			$perturbation = new Perturbation();
			$perturbation->addFormulation($formulation);
			$this->getCurrentUser()->addFormulation($formulation);
			$this->getCurrentUser()->addPerturbation($perturbation);

			#$em->persist($this->getCurrentUser());
			#$em->flush();
			$creation_date=date_format($perturbation->getCreationDate(), 'Y-m-d h-m-s');
			$begin_date=date_format($formulation->getBeginDate(), 'Y-m-d h-m-s');
			$end_date=date_format($formulation->getEndDate(), 'Y-m-d h-m-s');
			$redis = $this->get('snc_redis.default');
			$data_id = $redis->incr('data:id');
			$data_json = array(
				'data_id' => $data_id,
				'user_id' => $this->getCurrentUser()->getId(),
				'perturbation_id' => $perturbation->getId(),
				'perturbation_name' => $formulation->getName(),
				'perturbation_creation_date' => $creation_date,
				'description' => $formulation->getDescription(),
				'perturbation_type' => $formulation->getType()->getId(),
				'center' => $formulation->getCenter(),
				'begin_date' => $begin_date,
				'end_date' => $end_date
			);
			$json = json_encode($data_json);
			#$jsonKey= $formulation->getName();

			$redis->set ($data_id, $json);
			
			$request->getSession()->getFlashBag()->add('success', 'Perturbation bien enregistrée.');

			return $this->redirect($this->generateUrl('perturbation_list_nearest'));
		}

		return $this->render('AppBundle:Perturbation:add.html.twig', array('form' => $form->createView()));
	}

	/**
	* @Route("/perturbation/add-file/{id}", name="perturbation_add_file")
	*/
	public function addFileAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id);

		if ($perturbation != null) {

			$file = new File();
			$file->setParticulier($this->getCurrentUser());
		
			$form = $this->createForm(FilesType::class, $file);

			if ($form->handleRequest($request)->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($file);
				$em->flush();

				$file->uploadFile();

				$perturbationFile = new PerturbationFile();
				$perturbation->addFile($perturbationFile);
				$perturbationFile->setFile($file);
				
				$em->flush();
				
				$request->getSession()->getFlashBag()->add('success', 'Fichier(s) ajouté(s).');

				return $this->redirect($this->generateUrl('perturbation_show', array('id' => $perturbation->getId())));
			}
			
			return $this->render('AppBundle:Perturbation:addFile.html.twig', array(
				'form' => $form->createView(),
				'perturbation' => $perturbation,
			));

		}

		$request->getSession()->getFlashBag()->add('error', 'Perturbation non trouvée.');
		return $this->render('AppBundle:Perturbation:edit.html.twig', array('form' => $form->createView()));

	}

	/**
	* @Route("/perturbation/test/{center}", name="perturbation_test", defaults={
	* 		"center" : "POINT(2.586507797241211 48.841559662831)"
	* })
	*/
	public function testAction(Request $request, $center){

		//initialisation de elephant.io
		$client = new Client(new Version1X('http://localhost:8080'));
		$client ->initialize();

		$request->getSession()->getFlashBag()->add('notice', 'Nouvelle perturbation chargée.');
		$template = $this->container->get('templating')->render('AppBundle:Ajax:confirmation.html.twig');

		$client ->emit('emitPHP', [
			'message' => $template,
			'coordinates' => $center
		]);
		$client ->close();

		$request->getSession()->getFlashBag()->add('success', 'Evènement envoyé.');
		return $this->render('AppBundle:Ajax:confirmation.html.twig');
	}
	

	/**
	* @Route("/perturbation/show/{id}", name="perturbation_show")
	*/
	public function showAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id);

		if ($perturbation != null) {
			return $this->render('AppBundle:Perturbation:show.html.twig', array(
				'perturbation' => $perturbation
			));
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Perturbation non trouvée.');
			
			return $this->redirect($this->generateUrl('perturbation_index'));

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
	public function editAction(Request $request, $id){

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

				//initialisation de elephant.io
				$client = new Client(new Version1X('http://localhost:8080'));
				$client ->initialize();

				$request->getSession()->getFlashBag()->add('notice', 'Modification de perturbation chargée.');
				$template = $this->container->get('templating')->render('AppBundle:Ajax:confirmation.html.twig');

				$client ->emit('emitPHP', [
					'message' => $template,
					'coordinates' => $formulation->getCenter()
				]);
				$client ->close();
				
				$request->getSession()->getFlashBag()->add('success', 'Perturbation bien modifiée.');

				return $this->redirect($this->generateUrl('perturbation_show', array('id' => $id)));
			}

		}

		return $this->render('AppBundle:Perturbation:edit.html.twig', array('form' => $form->createView()));
		
	}

}


