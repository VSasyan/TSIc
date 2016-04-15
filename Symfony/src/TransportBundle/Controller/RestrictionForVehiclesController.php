<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TransportBundle\Entity\RestrictionForVehicles;
use TransportBundle\Form\RestrictionForVehiclesType;
use Symfony\Component\HttpFoundation\Request;

class RestrictionForVehiclesController extends Controller
{
    /**
     * @Route("/restrictionforvehicles/add")
     */
    public function addAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:RestrictionForVehicles');
        
        $restrictionType = new RestrictionForVehicles();
        $form = $this->createForm(RestrictionForVehiclesType::class, $restrictionType);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if($restrictionType->getRestrictionType() != null){
                try{
                    $em->persist($restrictionType);
                    $em->flush();
                }
                catch(exception $e){
                    print_r($e);
                }
            }
        
            return $this->render('TransportBundle:RestrictionForVehicles:update.html.php');
        }

        return $this->render('TransportBundle:RestrictionForVehicles:add.html.php',
            array('form' => $form->createView()
        ));
    }

    /**
     * @Route("/restrictionforvehicles/delete")
     */
    public function deleteAction()
    {   

        return $this->render('TransportBundle:RestrictionForVehicles:delete.html.php', array(
        ));
    }

    /**
     * @Route("/restrictionforvehicles/update")
     */
    public function updateAction()
    {
        return $this->render('TransportBundle:RestrictionForVehicles:update.html.php', array(
            // ...
        ));
    }

}
