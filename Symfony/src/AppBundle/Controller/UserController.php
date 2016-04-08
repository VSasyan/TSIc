<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\ParticulierRepository;
use AppBundle\Form\ParticulierType;
use AppBundle\Form\LoginType;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class UserController extends StatutController {

	/**
	 * @Route("/register", name="register")
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
        $session = $request->getSession();

        $helper = $this->get('security.authentication_utils');

        /*if ($request->attributes->has($helper->getLastAuthenticationError())) {
            $error = $request->attributes->get($helper->getLastAuthenticationError());
        } else {
            $error = $session->get($helper->getLastAuthenticationError());
            $session->remove($helper->getLastAuthenticationError());
        }*/

        return $this->render('AppBundle:User:login.html.twig', array(
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            )
        );
    }

    /**
    * @Method({"POST"})
    * @Route("/login_check", name="login_check")
    */
    public function check()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
    * @Method({"GET"})
    * @Route("/logout", name="logout")
    */
    public function logout()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
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

	/**
	* @Route("/check", name="check")
	*/
	public function checkUsersAction(){

		$user = $this->getCurrentUser();

		//print_r($user);

		return $this->render('AppBundle:User:check.html.twig', array(
            'user' => $user,
            'admin' => ($this->isAdmin() ? 'admin' : 'pas_admin'),
            'pro' => ($this->isPro() ? 'pro' : 'pas_pro'),
        )); 

	}

	/*
	* @Route("/user/upgrade/{id_user}/{id_status}", name="user_upgrade")
	*/
	public function upgradeUserAction($id_user, $id_status){
		
		return new Response('<html><body>upgradeUserAction!</body></html>');		
	}

}
