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
		$truc = new Node();
		$truc->setGeometry('point');

		$em = $this->getDoctrine()->getManager();
		$em->persist($truc);
		$em->flush();

		return $this->render('NetworkBundle:Default:index.html.twig');
	}
}
