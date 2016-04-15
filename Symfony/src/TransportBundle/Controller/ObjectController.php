<?php

namespace TransportBundle\Controller;

use TransportBundle\Entity\RoadLink;
use TransportBundle\Entity\RoadNode;

use TransportBundle\Form\RoadLinkType;
use TransportBundle\Form\RoadNodeType;

use AppBundle\Controller\StatutController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ObjectController extends StatutController {


	/**
	* @Route("/transport/index", name="transport_index")
	*/
	public function indexAction(){

		return $this->render('TransportBundle:Ajax:index.html.twig', array(
			'title' => 'Ajouter un nouvel object : un lien ou un noeud',
		));

	}

	/**
	* @Route("/transport/add", name="transport_add")
	*/
	public function addAction(Request $request){

		return $this->redirect($this->generateUrl('transport_link_add'));

	}

	/**
	* @Route("/transport/link/add", name="transport_link_add")
	*/
	public function addLinkAction(Request $request){

		$roadLink = new RoadLink();

		$form = $this->createForm(RoadLinkType::class, $roadLink);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$em->persist($roadLink);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Lien bien ajouté.');

			return $this->redirect($this->generateUrl('transport_link_add'));
		}

		return $this->render('AppBundle:Ajax:form.html.twig', array('form' => $form->createView()));
	}

	/**
	* @Route("/transport/node/add", name="transport_node_add")
	*/
	public function addNodeAction(Request $request){

		$roadLink = new RoadNode();

		$form = $this->createForm(RoadNodeType::class, $roadLink);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$em->persist($roadLink);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Noeud bien ajouté.');

			return $this->redirect($this->generateUrl('transport_node_add'));
		}

		return $this->render('AppBundle:Ajax:form.html.twig', array('form' => $form->createView()));
	}

}


