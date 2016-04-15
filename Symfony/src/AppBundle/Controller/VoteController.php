<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vote;
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
    * @Route("/perturbation/vote/{id_perturbation}/{id_message}", name="vote")
    */
	public function voteAction(Request $request, $id_perturbation, $id_message){

		//Si l'utilisateur est authentifié
		if ($this->isAuth()) {
			$em = $this->getDoctrine()->getManager();

			$perturbation = $em->getRepository('AppBundle:Perturbation')->find($id_perturbation);
			$message = $em->getRepository('AppBundle:Message')->find($id_message);

			// perturbation != null && $message != null?
			if ($perturbation != null && $message != null) {
				//$request->getSession()->getFlashBag()->add('notice', 'Perturbation et message associé valides.');

				// L'utilisateur a-t-il deja vote ?
				$vote = $em->getRepository('AppBundle:Vote')->findOneByParticulierPerturbationAndMessage($this->getCurrentId(), $perturbation->getId(), $message->getId());

				if ($vote == null) {

					// Creation du vote et ajoute à la perturbation
					$vote = new Vote();
					$vote->setMessage($message);
					$perturbation->addVote($vote);
					$this->getCurrentUser()->addVote($vote);
					$em->persist($vote);

					if ($this->isProfessionnel() | $this->isAdmin()) {

						if ($id_message == 1) {$perturbation->setActivated(false);}
						elseif ($id_message == 2) {$perturbation->setTerminated(true);}
						elseif ($id_message == 3) {$perturbation->setValid(true);}

						$em->persist($perturbation);

						$request->getSession()->getFlashBag()->add('success', 'Vous êtes une autorité, le status de la perturbation a été directement modifié.');

					} else {

						// Comptabilisation des messages !admin && !professionnel
						$nb_inhiber = 0;
						$nb_valider = 0;
						$nb_terminer = 0;

						//[activated, !valid, !terminated]
						foreach ($perturbation->getVotes() as $v) {
							$id = $v->getMessage()->getId();
						    if ($id == 1) {$nb_inhiber++;}
						    elseif ($id == 2) {$nb_valider++;}
						    elseif ($id == 3) {$nb_terminer++;}
						} 
						// 3 inhiber -> desactivee
						// 3 valider -> valide
						// 3 terminer -> terminee	
						define('VOTE_MIN', 2);
						if ($nb_inhiber > VOTE_MIN) {$perturbation->setActivated(false);}
						if ($nb_valider > VOTE_MIN) {$perturbation->setTerminated(true);}
						if ($nb_terminer > VOTE_MIN) {$perturbation->setValid(true);}

					}

					// Enregistrement dans la BD
					$em->flush();

					// Renvoyer message à utilisateur
					$request->getSession()->getFlashBag()->add('success', 'Le vote a été pris en compte.');

				} else {

					$request->getSession()->getFlashBag()->add('error', 'Vous avez déjà voté !');

				}
			}

		} else {

			$request->getSession()->getFlashBag()->add('error', 'Vous n\'êtes pas authentifié.');

		}

		return $this->render('AppBundle:Ajax:confirmation.html.twig');
	
	}

}


