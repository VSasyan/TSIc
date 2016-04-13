<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RestrictionForVehiclesController extends Controller
{
    /**
     * @Route("/restrictionforvehicles/add")
     */
    public function addAction()
    {
        return $this->render('TransportBundle:RestrictionForVehicles:add.html.php', array(
            // ...
        ));
    }

    /**
     * @Route("/restrictionforvehicles/delete")
     */
    public function deleteAction()
    {
        return $this->render('TransportBundle:RestrictionForVehicles:delete.html.php', array(
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
