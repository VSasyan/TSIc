<?php

namespace NetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
	/**
	 * @Route("/network", condition="request.getScriptName() == '/app_dev.php'")
	 */
	public function indexAction()
	{
		return $this->render('NetworkBundle:Default:index.html.twig');
	}
}
