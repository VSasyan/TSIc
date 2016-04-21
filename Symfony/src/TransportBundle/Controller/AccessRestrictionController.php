<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
<<<<<<< HEAD
=======
use TransportBundle\Entity\AccessRestriction;
use TransportBundle\Form\AccessRestrictionType;
use Symfony\Component\HttpFoundation\Request;
>>>>>>> 1bf6482940389076a985e334006bd7f46cee12e3

class AccessRestrictionController extends Controller
{
    /**
     * @Route("/accessRestriction/add")
     */
<<<<<<< HEAD
    public function addAction()
    {
        return $this->render('TransportBundle:AccessRestriction:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/accessRestriction/delete")
     */
    public function deleteAction()
    {
        return $this->render('TransportBundle:AccessRestriction:delete.html.twig', array(
            // ...
=======
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:AccessRestriction');
        
        $accessRestriction = new AccessRestriction();
        $form = $this->createForm(AccessRestrictionType::class, $accessRestriction);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if($accessRestriction->getRestriction() != null){
                try{
                    $em->persist($accessRestriction);
                    $em->flush();
                }
                catch(exception $e){
                    print_r($e);
                }
            }else {

            }
        
            return $this->render('TransportBundle:AccessRestriction:update.html.twig');
        }

        return $this->render('TransportBundle:AccessRestriction:add.html.twig', 
            array('form' => $form->createView()
        )); 
    }

    /**
     * @Route("/accessRestriction/delete/{id}")
     */
    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $Restriction = $em->getRepository('TransportBundle:AccessRestriction')->find($id);

        if (!$Restriction) {
            throw $this->createNotFoundException('No Access Restriction found for id '.$id);
        }

        $em->remove($Restriction);
        $em->flush();

        return $this->render('TransportBundle:AccessRestriction:delete.html.twig', array(
>>>>>>> 1bf6482940389076a985e334006bd7f46cee12e3
        ));
    }

    /**
<<<<<<< HEAD
     * @Route("/accesRestriction/update")
     */
    public function updateAction()
    {
        return $this->render('TransportBundle:AccessRestriction:update.html.twig', array(
            // ...
=======
     * @Route("/accesRestriction/update/{id_origin}")
     */
    public function updateAction(Request $request, $id_origin)
    {   
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:AccessRestriction');
       
        $accessRestriction = $repository->find($id_origin);
        $form = $this->createForm(AccessRestrictionType::class, $accessRestriction);

        if ($accessRestriction != null) {
            if ($form->handleRequest($request)->isValid()) {
            try{
                    $em->persist($accessRestriction);
                    $em->flush();
                }
                catch(exception $e){
                    print_r($e);
                }
            }
        }   

        return $this->render('TransportBundle:AccessRestriction:update.html.twig', array(
            'form' => $form->createView()
>>>>>>> 1bf6482940389076a985e334006bd7f46cee12e3
        ));
    }

}
