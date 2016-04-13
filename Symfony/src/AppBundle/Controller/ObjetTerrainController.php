<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ObjetTerrain;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ObjetTerrainController extends Controller {

	/**
	* @Route("/objet-terrain/list/nearest/{position}/{radius}", name="objet_terrain_list_nearest", defaults={
	*     "position": false,
	*     "radius": 1000
	* })
	*/
	public function listNearestAction($position, $radius) {

		$position = "ST_GeogFromText('SRID=4326;" . $position . "')";
		//$position = "ST_GeogFromText('SRID=4326; POINT(2.41859 48.84568)')";

		//get doctrine manager
		$em = $this->getDoctrine()->getManager();

		//get objectTerrain repository
		$repository = $em->getRepository('AppBundle:ObjetTerrain');

		//on récupère les perturbations les plus proches

		$objets = $repository->findNearest($position, $radius);

		$data = array();

		foreach ($objets as $objet) {

			$data[] = array(
				'name' => $objet->getName(),
				'geometry' => $objet->getGeometry(),
				'type' => $objet->getType(), // N'est pas un objet mais bel et bien l'id du type en integer
			);
							
		}

		$response = new JsonResponse();
		$response->setData($data);

		return $response;

	}

}

?>



