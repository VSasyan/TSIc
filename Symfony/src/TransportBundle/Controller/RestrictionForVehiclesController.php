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
            $accessRestriction->setRestriction($request->getRestriction());
        }
        $em->persist($user);
        $em->flush();

        return $this->render('TransportBundle:RestrictionForVehicles:add.html.php', array(
            // ...
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
            throw $this->createNotFoundException('No RestrictionForVehicles found for id '.$id);
        }

        $em->remove($Restriction);
        $em->flush();

        return $this->render('TransportBundle:RestrictionForVehicles:add.html.php', array(
            // ...
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
