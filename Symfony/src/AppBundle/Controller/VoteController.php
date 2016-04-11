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
    * @Route("/vote/{id_perturbation}/{id_message}", name="vote")
    */
	public function voteAction(Request $request, $id_perturbation, $id_message){

		//Si l'utilisateur est authentifié

		if ($this->isAuth()) {
			$em = $this->getDoctrine()->getManager();

			$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id_perturbation);
			$message = $em->getRepository('AppBundle:Message')->find($id_message);

			// perturbation != null && $message != null?
			if ($perturbation != null && $message != null) {
				$request->getSession()->getFlashBag()->add('success', 'Perturbation et message associé valides.');

				// Creation du vote et ajoute à la pertubation
				$vote = new Vote();
				$vote->setMessage($message);
				$pertubation->addVote($vote);
				$this->getCurrentUser()->addVote($vote);

				if (!$this->isProfessionnel() && !$this->isAdmin()) {
					// Comptabilisation des messages !admin && !professionnel
					$nb_inhiber = 0;
					$nb_valider = 0;
					$nb_terminer = 0;

					//[activated, !valid, !terminated]
					foreach ($pertubation->getVotes as $v) {

						$id = $v->getMessage->getId();
					    if ($id == 1) {$nb_inhiber++;}
					    elseif ($id == 2) {$nb_valider++;}
					    elseif ($id == 3) {$nb_terminer++;}
					} 
					// 3 inhiber -> desactivee
					// 3 valider -> valide
					// 3 terminer -> terminee	
					if ($nb_inhiber > 2) {$pertubation->setActivated(false);}
					if ($nb_valider > 2) {$pertubation->setValid(true);}
					if ($nb_terminer > 2) {$pertubation->setTerminated(true);}

				}
				else {
					$id = $message->getId();
					if ($id == 1) {$pertubation->setActivated(false);}
					elseif ($id == 2) {$pertubation->setValid(true);}
					elseif ($id == 3) {
						$pertubation->setTerminated(true);
					}
				}

				// Renvoyer message à utilisateur
				$request->getSession()->getFlashBag()->add('success', 'Le vote a été pris en compte.');
			}
			// Enregistrement dans la BD
			$em->flush();

			return $this->render('AppBundle:Ajax:confirmation.html.twig');
		}
		else {
			$request->getSession()->getFlashBag()->add('failed', 'Vous n êtes pas authentifié');
			$this->redirectToRoute('accueil');
		}
	
	}

}


