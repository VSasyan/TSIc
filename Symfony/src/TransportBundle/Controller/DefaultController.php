<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use TransportBundle\Entity\TransportLink;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
		$truc = new TransportLink;
		$truc->setGeographicalName("Bonjour");

		$em = $this->getDoctrine()->getManager();
		$em->persist($truc);
		$em->flush();
        
        return $this->render('TransportBundle:Default:index.html.twig', array("name" => $truc->getGeographicalName()));
    }
}
