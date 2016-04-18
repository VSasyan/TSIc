<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
<<<<<<< HEAD
=======
use TransportBundle\Entity\AccessRestriction;
use TransportBundle\Form\AccessRestrictionType;
>>>>>>> b57b4e797ec178e923935b162a74366928dfc18b
use Symfony\Component\HttpFoundation\Request;

class AccessRestrictionController extends Controller
{
    /**
     * @Route("/accessRestriction/add")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:AccessRestriction');
        
        $accessRestriction = new AccessRestriction();
        $form = $this->createForm(AccessRestrictionType::class, $accessRestriction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessRestriction->setRestriction($request->getRestriction());
        }
        $em->persist($accessRestriction);
        $em->flush();
        /*
        return $this->render('TransportBundle:AccessRestriction:add.html.twig', array(
            
<<<<<<< HEAD
        //));

        return $this->render('TransportBundle:AceesRestriction:add.html.twig', array(
            'restriction' => $accessRestriction,
=======
        ));
        */
        return $this->render('TransportBundle:AceesRestriction:add.html.twig', array(
            'accessRestriction' => $accessRestriction,
>>>>>>> b57b4e797ec178e923935b162a74366928dfc18b
            
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
            throw $this->createNotFoundException('No AccessRestriction found for id '.$id);
        }

        $em->remove($Restriction);
        $em->flush();
        return $this->render('TransportBundle:AccessRestriction:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/accesRestriction/update")
     */
    public function updateAction(Request $request, $id_AccessRestriction)
    {   
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:AccessRestriction');
        $accesRestriction = $repository->find($id_AccessRestriction);

        if($accesRestriction->getRestriction() == null){
            //throw 
        }
        
        $em->persist($accesRestriction);
        $em->flush();

        return $this->render('TransportBundle:AccessRestriction:add.html.twig', array(
            // ...
        ));
    }

}
