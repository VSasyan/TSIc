<?php

namespace AppBundle\Controller;

use SearchBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller {

	/*
	 * show
	 *
	 * return information about the given user
	*/

	/**
    * @Route("/user/show/{id}")
    */
	public function showUserAction($id){

		$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Particulier');
		$user = $repository->find($id);
		
		if (null === $user) {
			throw new NotFoundHttpException("Le user d'id ".$id." n'existe pas.");
		} else {
			$info = array(
				'user' => $user,
			);
		}

		return $this->render('AppBundle:User:show.html.twig', $info);
	}

	/**
    * @Route("/user/list")
    */
	public function listUsersAction(){

		$repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Particulier');
		$users = $repository->findAll();

		if (!users){
			throw $this->createNotFoundException(
        	    'No product found for id '
        	);

		}

		return $this->render('AppBundle:User:show.html.twig', $users); 

	}

	/*
    * @Route("/user/upgrade/{id_user}/{id_status}")
	*/

	/*
	public function upgradeUserAction($id){



	}
*/

}
