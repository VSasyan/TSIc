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
use TransportBundle\Entity\AccessRestrictionValue;
use TransportBundle\Entity\WeatherConditionValue;
use TransportBundle\Entity\RestrictionTypeValue;

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
			$gare->setLogoPicturePath('_1.png');
			$gare->setRadius(8000);
			$em->persist($gare);

			$autolib = new TypeObjetTerrain();
			$autolib->setName('Autolib');
			$autolib->setLogoPicturePath('_2.png');
			$autolib->setRadius(16000);
			$em->persist($autolib);

			$velo = new TypeObjetTerrain();
			$velo->setName('Vélo');
			$velo->setLogoPicturePath('_3.png');
			$velo->setRadius(16000);
			$em->persist($velo);

			$parking = new TypeObjetTerrain();
			$parking->setName('Parking');
			$parking->setLogoPicturePath('_4.png');
			$parking->setRadius(24000);
			$em->persist($parking);

			$parking_relais = new TypeObjetTerrain();
			$parking_relais->setName('Parking relais');
			$parking_relais->setLogoPicturePath('_5.png');
			$parking_relais->setRadius(24000);
			$em->persist($parking_relais);

			$station_taxis = new TypeObjetTerrain();
			$station_taxis->setName('Station de taxis');
			$station_taxis->setLogoPicturePath('_6.png');
			$station_taxis->setRadius(24000);
			$em->persist($station_taxis);

			$aire_covoit = new TypeObjetTerrain();
			$aire_covoit->setName('Aire de covoiturage');
			$aire_covoit->setLogoPicturePath('_7.png');
			$aire_covoit->setRadius(24000);
			$em->persist($aire_covoit);

			$borne_voit = new TypeObjetTerrain();
			$borne_voit->setName('Borne de rechargement de voiture');
			$borne_voit->setLogoPicturePath('_8.png');
			$borne_voit->setRadius(24000);
			$em->persist($borne_voit);

			// CREATION DES TYPES DE PERTURBATIONS

			$tp_ralentissement = new TypePerturbation();
			$tp_ralentissement->setName('Réduction de la vitesse');
			$tp_ralentissement->setLogoPicturePath('_1.png');
			$em->persist($tp_ralentissement);

			$tp_voies = new TypePerturbation();
			$tp_voies->setName('Réduction du nombre de voies');
			$tp_voies->setLogoPicturePath('_2.png');
			$em->persist($tp_voies);

			$tp_bloquee = new TypePerturbation();
			$tp_bloquee->setName('Route bloquée');
			$tp_bloquee->setLogoPicturePath('_3.png');
			$em->persist($tp_bloquee);

			// CREATION DES ENUM TRANSPORT::WEATHER

			$fog = new WeatherConditionValue();
			$fog->setName('Fog');
			$em->persist($fog);

			$snow = new WeatherConditionValue();
			$snow->setName('Snow');
			$em->persist($snow);

			$ice = new WeatherConditionValue();
			$ice->setName('Ice');
			$em->persist($ice);

			$rain = new WeatherConditionValue();
			$rain->setName('Rain');
			$em->persist($rain);


			$smog = new WeatherConditionValue();
			$smog->setName('Smog');
			$em->persist($smog);

			// CREATION DES ENUM TRANSPORT::ACCESS RESTRICTION

			$publicAccess = new AccessRestrictionValue();
			$publicAccess->setName('Public Access');
			$em->persist($publicAccess);

			$private = new AccessRestrictionValue();
			$private->setName('Private');
			$em->persist($private);

			$toll = new AccessRestrictionValue();
			$toll->setName('Toll');
			$em->persist($toll);

			$physicallyImpossible = new AccessRestrictionValue();
			$physicallyImpossible->setName('Physically Impossible');
			$em->persist($physicallyImpossible);

			$legalyForbidden = new AccessRestrictionValue();
			$legalyForbidden->setName('Legaly Forbidden');
			$em->persist($legalyForbidden);

			$seasonal= new AccessRestrictionValue();
			$seasonal->setName('Seasonal');
			$em->persist($seasonal);

			// CREATION DES ENUM TRANSPORT::VEHICULE RESTRICTION

			$maximumDoubleAxleWeight = new RestrictionTypeValue();
			$maximumDoubleAxleWeight->setName('Maximum Double Axle Weight');
			$em->persist($maximumDoubleAxleWeight);

			$maximumHeight = new RestrictionTypeValue();
			$maximumHeight->setName('Maximum Height');
			$em->persist($maximumHeight);

			$maximumLength = new RestrictionTypeValue();
			$maximumLength->setName('Maximum Length');
			$em->persist($maximumLength);

			$maximumSingleAxleWeight = new RestrictionTypeValue();
			$maximumSingleAxleWeight->setName('Maximum Single Axle Weight');
			$em->persist($maximumSingleAxleWeight);

			$maximumTotalWeight = new RestrictionTypeValue();
			$maximumTotalWeight->setName('Maximum Total Weight');
			$em->persist($maximumTotalWeight);

			$maximumTripleAxleWeight = new RestrictionTypeValue();
			$maximumTripleAxleWeight->setName('Maximum Triple Axle Weight');
			$em->persist($maximumTripleAxleWeight);

			$maximumWidth = new RestrictionTypeValue();
			$maximumWidth->setName('Maximum Width');
			$em->persist($maximumWidth);

			// CREATION DES ENUM TRANSPORT::FORM OF ROAD NODE

			$enclosedTrafficArea = new FormOfRoadNodeValue();
			$enclosedTrafficArea->setName('Enclosed Traffic Area');
			$em->persist($enclosedTrafficArea);

			$junction = new FormOfRoadNodeValue();
			$junction->setName('Junction');
			$em->persist($junction);

			$levelCrossing = new FormOfRoadNodeValue();
			$levelCrossing->setName('Level Crossing');
			$em->persist($levelCrossing);

			$pseudoNode = new FormOfRoadNodeValue();
			$pseudoNode->setName('Pseudo Node');
			$em->persist($pseudoNode);

			$roadEnd = new FormOfRoadNodeValue();
			$roadEnd->setName('Road End');
			$em->persist($roadEnd);

			$roadServiceArea = new FormOfRoadNodeValue();
			$roadServiceArea->setName('Road Service Area');
			$em->persist($roadServiceArea);

			$roundabout = new FormOfRoadNodeValue();
			$roundabout->setName('Roundabout');
			$em->persist($roundabout);

			$trafficSquare = new FormOfRoadNodeValue();
			$trafficSquare->setName('Traffic Square');
			$em->persist($trafficSquare);


			$em->flush();

			$request->getSession()->getFlashBag()->add('success', 'Base correctement initialisée.');

		} else {
			$request->getSession()->getFlashBag()->add('error', 'Vous n\' avez pas les droits !');
		}

		return $this->redirectToRoute('login');
	}
}


