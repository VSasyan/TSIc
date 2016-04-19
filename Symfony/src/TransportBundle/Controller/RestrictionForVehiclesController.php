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
     * @Route("/restrictionforvehicles/delete/{id}")
     */
    public function deleteAction(Request $request, $id)
    {   

        $em = $this->getDoctrine()->getEntityManager();
        $Restriction = $em->getRepository('TransportBundle:RestrictionForVehicles')->find($id);

        if (!$Restriction) {
            throw $this->createNotFoundException('No Restriction ForVehicles found for id '.$inspireid);
        }

        $em->remove($Restriction);
        $em->flush();

        return $this->render('TransportBundle:RestrictionForVehicles:delete.html.php', array(
        ));
    }

    /**
     * @Route("/restrictionforvehicles/update/{id_origin}")
     */
    public function updateAction(Request $request, $id_origin)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:RestrictionForVehicles');
       
        $restrictionForVehicles = $repository->find($id_origin);
        $form = $this->createForm(RestrictionForVehiclesType::class, $restrictionForVehicles);

        if ($restrictionForVehicles != null) {
            if ($form->handleRequest($request)->isValid()) {
            try{
                    $em->persist($restrictionForVehicles);
                    $em->flush();
                }
                catch(exception $e){
                    print_r($e);
                }
            }
        }   
        return $this->render('TransportBundle:RestrictionForVehicles:update.html.php', array(
            'form' => $form->createView()
        ));
    }

}
