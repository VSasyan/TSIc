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
	* @Route("/transport/add", name="transport_add")
	*/
	public function addAction(Request $request){

		return $this->render('TransportBundle:Objects:add.html.twig');

	}

	/**
	* @Route("/transport/link/add", name="transport_link_add")
	*/
	public function addLinkAction(Request $request){

		$messages = '';

		$roadLink = new RoadLink();

		$form = $this->createForm(RoadLinkType::class, $roadLink);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$em->persist($roadLink);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Lien bien ajouté.');

            $messages .= $this->container->get('templating')->render('AppBundle:Ajax:confirmation.html.twig');

            $form = $this->createForm(RoadLinkType::class, new RoadLink);
		}

		$template = $this->container->get('templating')->render('AppBundle:Ajax:form.html.twig', array(
			'form' => $form->createView(),
			'url_action' => "transport_link_add"
		));
		$response = new Response(json_encode(array(
			'title'	  => "Ajout d'un lien",
			'content' => $template,
			'messages' => $messages,
		)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	* @Route("/transport/node/add", name="transport_node_add")
	*/
	public function addNodeAction(Request $request){

		$messages = '';

		$roadNode = new RoadNode();

		$form = $this->createForm(RoadNodeType::class, $roadNode);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$em->persist($roadNode);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Noeud bien ajouté.');

			$messages .= $this->container->get('templating')->render('AppBundle:Ajax:confirmation.html.twig');

			$form = $this->createForm(RoadNodeType::class, new RoadNode);
		}

		$template = $this->container->get('templating')->render('AppBundle:Ajax:form.html.twig', array(
			'form' => $form->createView(),
			'url_action' => "transport_node_add"
		));
		$response = new Response(json_encode(array(
			'title'	  => "Ajout d'un nœud",
			'content' => $template,
			'messages' => $messages,
		)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

}


