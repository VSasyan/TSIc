<?php

namespace NetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use NetworkBundle\Entity\Node;
use NetworkBundle\Entity\Link;

class DefaultController extends Controller
{
	/**
	 * @Route("/test-network")
	 */
	public function indexAction()
	{
		$node = new Node();
		$node->setGeometry('point');

		$link = new Link();
		$link->setCentrelineGeometry("ligne");

		$link->setStartNode($node);

		$em = $this->getDoctrine()->getManager();
		$em->persist($node);
		$em->persist($link);
		$em->flush();

		return $this->render('NetworkBundle:Default:index.html.twig', array(
			"node"	   => $node->getGeometry(),
			"link"	   => $link->getCentrelineGeometry(),
			"linknode" => $link->getStartNode()->getGeometry()
		));
	}
}
