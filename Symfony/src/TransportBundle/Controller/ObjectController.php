<?php

namespace TransportBundle\Controller;

use TransportBundle\Entity\RoadLink;
use TransportBundle\Entity\RoadNode;

use TransportBundle\Form\RoadLinkType;
use TransportBundle\Form\RoadNodeType;

use AppBundle\Controller\StatutController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ObjectController extends StatutController {


	/**
	* @Route("/transport/index", name="transport_index")
	*/
	public function indexAction(){

		return $this->render('TransportBundle:Default:index.html.twig');

	}

	/**
	* @Route("/transport/add", name="transport_add")
	*/
	public function addAction(Request $request){

		return $this->redirect($this->generateUrl('transport_link_add'));

	}

	/**
	* @Route("/transport/list/nearest/{position}/{radius}", name="transport_list_nearest", defaults={
	*	  "position" : false,
	*     "radius": 1000
	* })
	*/
	public function listNearestAction($position, $radius){

		$em = $this->getDoctrine()->getManager('osm');
		$nodeRepository = $em->getRepository('TransportBundle:RoadNode');
		$linkRepository = $em->getRepository('TransportBundle:RoadLink');
		
		if($position == false) {

			return $this->render('TransportBundle:Default:list_nearest.html.twig', array(
				'function' => 'listNearestObjects'
				)
			);
		}

		$position = "ST_GeomFromText('" . $position . "',4326)";

		$nodes = $nodeRepository->findNearest($position, $radius);
		$links = $linkRepository->findNearest($position, $radius);

		$virtualNodes = array();

		foreach ($nodes as $node) {

			$virtualNodes[] = array(
				'name' => $node->getGeographicalName(),
				'geometry' => $node->getGeometry(),
			);				
		}

		$virtualLinks = array();

		foreach ($links as $link) {

			$virtualLinks[] = array(
				'name' => $link->getGeographicalName(),
				'geometry' => $link->getCentrelineGeometry(),
			);				
		}

		$objects = array_merge($virtualNodes, $virtualLinks);

		$response = new JsonResponse();
		$response->setData($objects);
		return $response;

	}

	/**
	* @Route("/transport/link/add", name="transport_link_add")
	*/
	public function addLinkAction(Request $request){

		$messages = '';

		$roadLink = new RoadLink();

		$form = $this->createForm(RoadLinkType::class, $roadLink);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager('osm');

			$em->persist($roadLink);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Lien bien ajouté');

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
			$em = $this->getDoctrine()->getManager('osm');

			$em->persist($roadNode);
			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Noeud bien ajouté');

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


