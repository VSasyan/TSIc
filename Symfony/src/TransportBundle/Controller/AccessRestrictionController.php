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
        ));
    }

    /**
     * @Route("/accesRestriction/update")
     */
    public function updateAction()
    {
        return $this->render('TransportBundle:AccessRestriction:update.html.twig', array(
            // ...
        ));
    }

}
