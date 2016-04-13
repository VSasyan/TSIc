<?php

namespace NetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use NetworkBundle\Entity\GeneralisedLink;

class DefaultController extends Controller
{
	/**
	 * @Route("/")
	 */
	public function indexAction()
	{
		return $this->render('NetworkBundle:Default:index.html.twig');
	}
}
