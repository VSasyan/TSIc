<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TransportBundle\Entity\AccessRestriction;
use TransportBundle\Form\AccessRestrictionType;
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
            
        ));
        */
        return $this->render('TransportBundle:AceesRestriction:add.html.twig', array(
            'accessRestriction' => $accessRestriction,
            
        )); 
    }

    /**
     * @Route("/accessRestriction/delete")
     */
    public function deleteAction()
    {
        return $this->render('TransportBundle:AccessRestriction:delete.html.twig', array(
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

        return $this->render('TransportBundle:AccessRestriction:update.html.twig', array(
            // ...
        ));
    }

}
