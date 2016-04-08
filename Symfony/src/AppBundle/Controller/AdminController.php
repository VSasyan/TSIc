<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\Admin;
use AppBundle\Entity\Particulier;
use AppBundle\Entity\Professionnel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends StatutController {

	/**
	* @Route("/administration", name="administration")
	*/
	public function administrationAction(Request $request){
		if ($this->isAdmin()) {
			return $this->render('AppBundle:Admin:administration.html.twig');
		}
		return $this->redirectToRoute('accueil');
	}

	/**
	* @Route("/init", name="init")
	*/
	public function initAction(Request $request){
		
		$em = $this->getDoctrine()->getManager();
		$users = $em->getRepository('AppBundle:Particulier')->findAll();

		if (count($users) == 0) {

			// CREATION DES UTILISATEURS :

			// user :
			$user = new Particulier();
			$user->setUsername('user');
			$user->setName('user');
			$user->setLastname('user');
			$user->setPassword(password_hash('user', PASSWORD_BCRYPT));
			$user->setEmail('user@me.fr');
			$em->persist($user);
			
			// pro :		
			$pro = new Particulier();
			$pro->setUsername('pro');
			$pro->setName('pro');
			$pro->setLastname('pro');
			$pro->setPassword(password_hash('pro', PASSWORD_BCRYPT));
			$pro->setEmail('pro@me.fr');
			$pro->setProfessionnal(new Professionnel());
				$pro->getProfessionnal()->setPost('mon poste');
				$pro->getProfessionnal()->setOrganisation('mon organisation');
			$em->persist($pro);
			
			// admin :		
			$admin = new Particulier();
			$admin->setUsername('admin');
			$admin->setName('admin');
			$admin->setLastname('admin');
			$admin->setPassword(password_hash('admin', PASSWORD_BCRYPT));
			$admin->setEmail('admin@me.fr');
			$admin->setAdmin(new Admin());
			$em->persist($admin);


			// CREATION DES MESSAGES

			$inhiber = new Message();
			$inhiber->setName('Inhiber');
			$em->persist($inhiber);

			$terminer = new Message();
			$terminer->setName('Terminer');
			$em->persist($terminer);

			$valider = new Message();
			$valider->setName('Valider');
			$em->persist($valider);

			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Base correctement initialisée.');

		} else {
			$request->getSession()->getFlashBag()->add('error', 'Vous n\' avez pas les droits !');
		}

		return $this->redirectToRoute('login');
	}
}


