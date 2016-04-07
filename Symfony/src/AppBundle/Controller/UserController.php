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
        $form = $this->createForm(LoginType::class, new Particulier());

        if ($request->isMethod('post')){
            $user = $request->request->get('_username');
            $password_check = $request->request->get('_password');
            $em = $this->getDoctrine();
            $repo  = $em->getRepository("AppBundle:Particulier");

            $user_base = $repo->loadUserByUsername($user);

            if($user_base != null){
                $EncodedPassword = $user_base->getPassword();
                $password = password_verify($password_check, $EncodedPassword);

                if($password == true){
                    print_r("teste reussi ");
                    //return $this->redirectToRoute('accueil');
                     
                }
            }
            $request->getSession()->getFlashBag()->add('error', 'incorrect identification');
        }
        
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AppBundle:User:login2.html.twig',
            array('form' => $form->createView())
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
