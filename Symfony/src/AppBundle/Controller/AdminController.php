<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\Admin;
use AppBundle\Entity\Particulier;
use AppBundle\Entity\Professionnel;
use AppBundle\Entity\TypePerturbation;
use AppBundle\Entity\TypeObjetTerrain;
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

			// CREATION DES TYPES D'OBJETS TERRAIN

			$gare = new TypeObjetTerrain();
			$gare->setName('Gare');
			$gare->setLogoPicturePath('1.png');
			$em->persist($gare);

			$autolib = new TypeObjetTerrain();
			$autolib->setName('Autolib');
			$autolib->setLogoPicturePath('2.png');
			$em->persist($autolib);

			$velo = new TypeObjetTerrain();
			$velo->setName('Vélo');
			$velo->setLogoPicturePath('3.png');
			$em->persist($velo);

			$parking = new TypeObjetTerrain();
			$parking->setName('Parking');
			$parking->setLogoPicturePath('4.png');
			$em->persist($parking);

			$parking_relais = new TypeObjetTerrain();
			$parking_relais->setName('Parking relais');
			$parking_relais->setLogoPicturePath('5.png');
			$em->persist($parking_relais);

			$station_taxis = new TypeObjetTerrain();
			$station_taxis->setName('Station de taxis');
			$station_taxis->setLogoPicturePath('6.png');
			$em->persist($station_taxis);

			$aire_covoit = new TypeObjetTerrain();
			$aire_covoit->setName('Aire de covoiturage');
			$aire_covoit->setLogoPicturePath('7.png');
			$em->persist($aire_covoit);

			$borne_voit = new TypeObjetTerrain();
			$borne_voit->setName('Borne de rechargement de voiture');
			$borne_voit->setLogoPicturePath('8.png');
			$em->persist($borne_voit);

			// CREATION DES TYPES DE PERTURBATIONS

			$tp_bloquee = new TypePerturbation();
			$tp_bloquee->setName('Route bloquée');
			$tp_bloquee->setLogoPicturePath('1.png');
			$em->persist($tp_bloquee);

			$tp_voies = new TypePerturbation();
			$tp_voies->setName('Reduction du nombre de voies');
			$tp_voies->setLogoPicturePath('2.png');
			$em->persist($tp_voies);

			$tp_ralentissement = new TypePerturbation();
			$tp_ralentissement->setName('Ralentissement');
			$tp_ralentissement->setLogoPicturePath('3.png');
			$em->persist($tp_ralentissement);

			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Base correctement initialisée.');

		} else {
			$request->getSession()->getFlashBag()->add('error', 'Vous n\' avez pas les droits !');
		}

		return $this->redirectToRoute('login');
	}
}


