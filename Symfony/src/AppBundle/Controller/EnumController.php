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
			
			$request->getSession()->getFlashBag()->add('success', 'Type de perturbation bien créé.');

			return $this->redirect($this->generateUrl('type_edit', array('id' => $type->getId())));
		}

		return $this->render('AppBundle:Enum:add.html.twig', array(
			'rm' => $form->createView(),
			'title' => 'Ajouter un type de perturbation'
		));

	}

	/**
	* @Route("/type/list", name="type_list")
	*/
	public function mtypeListAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();
		$elements = $em()->getRepository('AppBundle:Type')->findAll());

		return $this->render('AppBundle:Enum:edit.html.twig', array(
			'elements' => $elements,
			'title' => 'Liste des types'
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
				$request->getSession()->getFlashBag()->add('success', 'Type de perturbation bien edité.');
			}
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Type de perturbation non trouvé.');
			return $this->redirect($this->generateUrl('type_list'));
		}

		return $this->render('AppBundle:Enum:edit.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Editer un type de perturbation'
		));

	}

	/**
	* @Route("/type/delete/{id}", name="type_delete")
	*/
	public function typeDeleteAction($id){

		$em = $this->getDoctrine()->getManager();
		$type = $em()->getRepository('AppBundle:Type')->find($id);

		if ($type != null) {
			$em()->remove($type);
			$em()->flush();
			$request->getSession()->getFlashBag()->add('success', 'Type bien supprimé.');
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Type non trouvé.');
		}

		return $this->redirect($this->generateUrl('type_list'));

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

			$request->getSession()->getFlashBag()->add('success', 'Message bien créé.');
			return $this->redirect($this->generateUrl('message_edit', array('id' => $message->getId())));
		}

		return $this->render('AppBundle:Enum:add.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Ajouter un message'
		));

	}

	/**
	* @Route("/message/list", name="message_list")
	*/
	public function messageListAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();
		$elements = $em()->getRepository('AppBundle:Message')->findAll());

		return $this->render('AppBundle:Enum:edit.html.twig', array(
			'elements' => $elements,
			'title' => 'Liste des messages'
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
				$request->getSession()->getFlashBag()->add('success', 'Message bien edité.');
			}
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Message non trouvé.');
		}
		
		return $this->render('AppBundle:Enum:edit.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Editer un message'
		));

	}

	/**
	* @Route("/message/delete/{id}", name="message_delete")
	*/
	public function messageDeleteAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();
		$message = $em()->getRepository('AppBundle:Message')->find($id);

		if ($message != null) {
			$em()->remove($message);
			$em()->flush();
			$request->getSession()->getFlashBag()->add('success', 'Message bien supprimé.');
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Message non trouvé.');
		}

		return $this->redirect($this->generateUrl('message_list'));

	}
}


