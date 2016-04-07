<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\ParticulierRepository;
use AppBundle\Form\ParticulierType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class UserController extends StatutController {

    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        // 
        $user = new Particulier();
        $form = $this->createForm(ParticulierType::class, $user);

        // 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'AppBundle:User:register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $user = new Particulier();
        $form = $this->createForm(ParticulierType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isAuth()) {
            return $this->redirectToRoute('accueil');
            
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AppBundle:User:login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
        }


	/*
	 * show
	 *
	 * return information about the given user
	 *
     * @Route("/user/show/{id}", name="user_show")
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
    * @Route("/user/list", name="user_list")
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
    * @Route("/user/upgrade/{id_user}/{id_status}", name="user_upgrade")
	*/
	public function upgradeUserAction($id_user, $id_status){
        
        return new Response('<html><body>upgradeUserAction!</body></html>');        
	}

}
