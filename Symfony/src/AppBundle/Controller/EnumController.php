<?php

namespace AppBundle\Controller;

use SearchBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EnumController extends Controller {

	/**
    * @Route("/type/add", name="type_add")
    */
	public function typeAddAction(Request $request){

		$type = new Type();
	    $form = $this->get('form.factory')->create(new TypeType(), $type);

	    if ($form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($type);
	      $em->flush();

	      return $this->redirect($this->generateUrl('type_edit', array('id' => $type->getId())));
	    }

	    return $this->render('AppBundle:Type:add.html.twig', array(
	      'form' => $form->createView(),
	    ));

	}

	/**
    * @Route("/type/edit/{id}", name="type_edit")
    */
	public function typeEditAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();
		$type = $em()->getRepository('AppBundle:Type')->find($id);

		if ($type != null) {
		    $form = $this->get('form.factory')->create(new TypeType(), $type);

		    if ($form->handleRequest($request)->isValid()) {
		      $em->persist($type);
		      $em->flush();

		      return $this->redirect($this->generateUrl('type_edit', array('id' => $type->getId())));
		    }

		    return $this->redirect($this->generateUrl('type_edit', array('id' => $type->getId())));
		}
		return $this->render('AppBundle:Type:add.html.twig', array(
		  'form' => $form->createView(),
		    ));

	}

	/**
    * @Route("/type/delete/{id}", name="type_delete")
    */
	public function typeDeleteAction($id){

		$em = $this->getDoctrine()->getManager();
		$type = $em()->getRepository('AppBundle:Type')->find($id);

		if ($type != null) {
		    $form = $this->get('form.factory')->create(new TypeType(), $type);

		    if ($form->handleRequest($request)->isValid()) {
		      $em->remove($type);
		      $em->flush();

		      return $this->render('AppBundle:Type:add.html.twig', array(
		  		'form' => $form->createView(),
		    	  ));
		    }

		    return $this->render('AppBundle:Type:add.html.twig', array(
		  	'form' => $form->createView(),
		      ));
		}
		return $this->render('AppBundle:Type:add.html.twig', array(
		  'form' => $form->createView(),
		    ));

	}

	/**
    * @Route("/message/add", name="message_add")
    */
	public function messageAddAction(Request $request){

		$message = new Message();
	    $form = $this->get('form.factory')->create(new MessageType(), $message);

	    if ($form->handleRequest($request)->isValid()) {
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($message);
	      $em->flush();

	      return $this->redirect($this->generateUrl('message_edit', array('id' => $message->getId())));
	    }

	    return $this->render('AppBundle:Message:add.html.twig', array(
	      'form' => $form->createView(),
	    ));

	}


	/**
    * @Route("/message/edit/{id}", name="message_edit")
    */
	public function messageEditAction(Request $request, $id){
	    
	    $em = $this->getDoctrine()->getManager();
		$message = $em()->getRepository('AppBundle:Message')->find($id);

		if ($message != null) {
		    $form = $this->get('form.factory')->create(new MessageType(), $message);

		    if ($form->handleRequest($request)->isValid()) {
		      $em->persist($message);
		      $em->flush();

		      return $this->redirect($this->generateUrl('message_edit', array('id' => $message->getId())));
		    }

		    return $this->redirect($this->generateUrl('message_edit', array('id' => $message->getId())));
		}
		return $this->render('AppBundle:Message:add.html.twig', array(
		  'form' => $form->createView(),
		    ));

	}


	/**
    * @Route("/message/delete/{id}", name="message_delete")
    */
	public function messageDeleteAction($id){

		$em = $this->getDoctrine()->getManager();
		$message = $em()->getRepository('AppBundle:Message')->find($id);

		if ($message != null) {
		    $form = $this->get('form.factory')->create(new MessageType(), $message);

		    if ($form->handleRequest($request)->isValid()) {
		      $em->remove($message);
		      $em->flush();

		      return $this->render('AppBundle:Message:add.html.twig', array(
		  		'form' => $form->createView(),
		    	  ));
		    }

		    return $this->render('AppBundle:Message:add.html.twig', array(
		  	'form' => $form->createView(),
		      ));
		}
		return $this->render('AppBundle:Message:add.html.twig', array(
		  'form' => $form->createView(),
		    ));

	}
}


