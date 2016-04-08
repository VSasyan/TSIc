<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Particulier;
use AppBundle\Entity\Perturbation;
use AppBundle\Entity\Formulation;
use AppBundle\Form\FormulationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class VoteController extends StatutController {

	/**
    * @Route("/perturbation/vote/{id_perturbation}/{id_message}", name="perturbation_vote")
    */
	public function voteAction($Request $request, $id_perturbation, $id_message){

		$em = $this->getDoctrine()->getManager();

		$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id_perturbation);
		$message = $em->getRepository('AppBundle:Message')->find($id_message);

		// perturbation != null && $message != null?
		$request->getSession()->getFlashBag()->add('success', 'Type de perturbation bien créé.');



		// Creation du vote et ajoute à la paertubation


		// Comttabilisation des messages !admin && !professionnel

		//[activee, non_valide, non_archivee]


		// 3 inhiber -> desactivee
		// 3 validé -> valide
		// 3 terminée -> terminee

		// Set etat cache (admin | pro)

		// Renvoyer message à utilisateur


		//$em->flush();

		return $this->render('AppBundle:Ajax:confirmation.html.twig');
	
	}




}


