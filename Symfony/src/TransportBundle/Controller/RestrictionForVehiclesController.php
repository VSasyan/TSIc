<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RestrictionForVehiclesController extends Controller
{
    /**
     * @Route("/restrictionforvehicles/add")
     */
    public function addAction()
    {   
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:RestrictionForVehicles');
        
        $vehicleRestriction = new RestrictionForVehicles();
        $form = $this->createForm(RestrictionForVehicles::class, $vehicleRestriction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicleRestriction->setRestriction($request->getRestriction());
        }
        $em->persist($user);
        $em->flush();

        return $this->render('TransportBundle:RestrictionForVehicles:add.html.php', array(
            
        ));
    }

    /**
     * @Route("/restrictionforvehicles/delete/{id}")
     */
<<<<<<< HEAD
    public function deleteAction(Request $request, $id)
    {

        

        $em = $this->getDoctrine()->getEntityManager();
        $Restriction = $em->getRepository('TransportBundle:RestrictionForVehicles')->find($id);

        if (!$Restriction) {
            throw $this->createNotFoundException('No RestrictionForVehicles found for id '.$id);
        }

        $em->remove($Restriction);
        $em->flush();

        return $this->render('TransportBundle:RestrictionForVehicles:add.html.php', array(
            // ...
=======
    public function deleteAction()
    {   

        return $this->render('TransportBundle:RestrictionForVehicles:delete.html.php', array(
>>>>>>> b57b4e797ec178e923935b162a74366928dfc18b
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
