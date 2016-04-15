<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TransportBundle\Entity\WeatherCondition;
use TransportBundle\Form\WeatherConditionType;
use Symfony\Component\HttpFoundation\Request;

class WeatherConditionValueController extends Controller
{

    /**
     * @Route("/weathercondition/add")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:WeatherCondition');
        
        $weatherValue = new WeatherCondition();
        $form = $this->createForm(WeatherConditionType::class, $weatherValue);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if($weatherValue->getweatherConditionValue() != null){
                try{
                    $em->persist($weatherValue);
                    $em->flush();
                }
                catch(exception $e){
                    print_r($e);
                }
            }
        
            return $this->render('TransportBundle:WeatherConditionValue:delete.html.php');
        }

        return $this->render('TransportBundle:WeatherConditionValue:add.html.php', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/weathercondition/update")
     */
    public function updateAction()
    {
        return $this->render('TransportBundle:WeatherConditionValue:update.html.php', array(
            // ...
        ));
    }

    /**
     * @Route("/weathercondition/delete/{id}")
     */
    public function deleteAction(Request $request, $id)
    {   

        $em = $this->getDoctrine()->getEntityManager();
        $condition = $em->getRepository('TransportBundle:WeatherCondition')->find($id);

        if (!$condition) {
            //redirect
            throw $this->createNotFoundException('No Weather Condition found for '.$id);
        }

        $em->remove($condition);
        $em->flush();

        return $this->render('TransportBundle:RestrictionForVehicles:update.html.php', array(
        ));
    }

}
