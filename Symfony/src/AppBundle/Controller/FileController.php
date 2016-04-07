<?php

namespace AppBundle\Controller;


use AppBundle\Entity\TypePerturbation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FileController extends StatutController {

	/**
	* @Route("/file/logo-type-perturbation/{id}", name="logo_type_perturbation", defaults={"id": 0})
	*/
	public function logoTypePerturbationAction($id = 0) {
		$dir_logo = __DIR__ . '/../../../upload/logo_type_perturbation/';
		$type = $this->getDoctrine()->getManager()->getRepository('AppBundle:TypePerturbation')->find($id);
		$filename = '../logo_type_perturbation_default.png';
		if ($type && $type->getLogoPicturePath()){
			$filename = $type->getLogoPicturePath();
		}
		if (!file_exists($dir_logo . $filename)) {
			$filename = '../logo_type_perturbation_default.png';
		}
		$path =  $dir_logo . $filename;

		// Generate response
		$response = new Response();

		// Set headers
		$response->headers->set('Cache-Control', 'private');
		$response->headers->set('Content-type', mime_content_type($path));
		$response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
		$response->headers->set('Content-length', filesize($path));
		$response->sendHeaders();
		$response->setContent(file_get_contents($path));

		return $response;
	}
}