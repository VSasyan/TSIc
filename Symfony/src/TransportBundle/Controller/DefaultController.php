<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
	/**
	 * @Route("/transport", condition="request.getScriptName() == '/app_dev.php'")
	 */
	public function indexAction()
	{
		return $this->render('TransportBundle:Default:index.html.twig');
	}
}
