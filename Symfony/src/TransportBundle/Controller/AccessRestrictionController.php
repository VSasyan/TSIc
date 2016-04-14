<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AccessRestrictionController extends Controller
{
    /**
     * @Route("/accessRestriction/add")
     */
    public function addAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:AccessRestriction');
        
        $accessRestriction = new AccessRestriction();
        $form = $this->createForm(AccessRestrictionType::class, $accessRestriction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accessRestriction->setRestriction($request->getRestriction());
        }
        $em->persist($user);
        $em->flush();
        
        //return $this->render('TransportBundle:Ajax:form.html.twig', array(
            
        //));

        return $this->render('AppBundle:AceesRestriction:add.html.twig', array(
            'restriction' => $accessRestriction,
            
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
        $repository = $em->getRepository('AppBundle:AccessRestriction');
        $accesRestriction = $repository->find($id_AccessRestriction);

        if($accesRestriction->getRestriction() == null){
            //throw 
        }
        
        $em->persist($user);
        $em->flush();

        return $this->render('TransportBundle:AccessRestriction:update.html.twig', array(
            // ...
        ));
    }

}
