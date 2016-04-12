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
		$truc = new GeneralisedLink();
		$truc->setToto(1);

		$em = $this->getDoctrine()->getManager();
		$em->persist($truc);
		$em->flush();

        return $this->render('NetworkBundle:Default:index.html.twig');
    }
}
