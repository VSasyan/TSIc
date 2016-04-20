<?php

namespace TransportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TransportBundle\Entity\WeatherCondition;
use TransportBundle\Entity\WeatherConditionValue;
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
     * @Route("/weathercondition/update/{id_origin}")
     */
    public function updateAction(Request $request, $id_origin)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('TransportBundle:WeatherCondition');
       
        $weatherCondition = $repository->find($id_origin);
        $form = $this->createForm(WeatherConditionType::class, $weatherCondition);

        if ($weatherCondition != null) {
            if ($form->handleRequest($request)->isValid()) {
            try{
                    $em->persist($weatherCondition);
                    $em->flush();
                }
                catch(exception $e){
                    print_r($e);
                }
            }
        }   

        return $this->render('TransportBundle:WeatherConditionValue:update.html.php', array(
            'form' => $form->createView()
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
