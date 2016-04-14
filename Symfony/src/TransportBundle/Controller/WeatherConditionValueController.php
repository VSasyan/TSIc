<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WeatherConditionValueController extends Controller
{

    /**
     * @Route("/weatherconditionvalue/add")
     */
    public function addAction(Request $request)
    {
        /*$weather = new WeatherConditionValue();
        $form = $this->createForm(ParticulierType::class, $weather);

        // 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }*/

        return $this->render('TransportBundle:WeatherConditionValue:add.html.php', array(
            // ...
        ));
    }

    /**
     * @Route("/weatherconditionvalue/update")
     */
    public function updateAction()
    {
        return $this->render('TransportBundle:WeatherConditionValue:update.html.php', array(
            // ...
        ));
    }

    /**
     * @Route("/weatherconditionvalue/delete")
     */
    public function deleteAction()
    {
        return $this->render('TransportBundle:WeatherConditionValue:delete.html.php', array(
            // ...
        ));
    }

}
