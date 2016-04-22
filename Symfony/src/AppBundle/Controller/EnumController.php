<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\TypePerturbation;
use AppBundle\Entity\TypeObjetTerrain;
use AppBundle\Form\MessageType;
use AppBundle\Form\TypePerturbationType;
use AppBundle\Form\TypeObjetTerrainType;
use AppBundle\Repository\MessageRepository;
use AppBundle\Repository\TypePerturbationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EnumController extends Controller {

	/**
	* @Route("/type-perturbation/add", name="type_perturbation_add")
	*/
	public function typePerturbationAddAction(Request $request){

		$type = new TypePerturbation();
		$form = $this->createForm(TypePerturbationType::class, $type);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($type);
			$em->flush();

			$type->uploadLogoPicture();
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Type de perturbation bien créé.');

			return $this->redirect($this->generateUrl('type_perturbation_edit', array('id' => $type->getId())));
		}

		return $this->render('AppBundle:Enum:add.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Ajouter un type de perturbation'
		));

	}

	/**
	* @Route("/type-perturbation/list", name="type_perturbation_list")
	*/
	public function typePerturbationListAction(Request $request){

		$em = $this->getDoctrine()->getManager();
		$elements = $em->getRepository('AppBundle:TypePerturbation')->findAll();

		return $this->render('AppBundle:Enum:list.html.twig', array(
			'elements' => $elements,
			'title' => 'Liste des types',
			'route_edit' => 'type_perturbation_edit',
			'route_logo' => 'logo_type_perturbation',
			'route_delete' => 'type_perturbation_delete'
		));

	}

	/**
	* @Route("/type-perturbation/edit/{id}", name="type_perturbation_edit")
	*/
	public function typePerturbationEditAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:TypePerturbation')->find($id);

		if ($type != null) {
			$form = $this->createForm(TypePerturbationType::class, $type);

			if ($form->handleRequest($request)->isValid()) {
				$type->uploadLogoPicture();
				$em->persist($type);
				$em->flush();
				$request->getSession()->getFlashBag()->add('success', 'Type de perturbation bien edité.');
			}
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Type de perturbation non trouvé.');
			return $this->redirect($this->generateUrl('type_perturbation_list'));
		}

		return $this->render('AppBundle:Enum:edit.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Editer un type de perturbation'
		));

	}

	/**
	* @Route("/type-perturbation/delete/{id}", name="type_perturbation_delete")
	*/
	public function typePerturbationDeleteAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:TypePerturbation')->find($id);

		if ($type != null) {
			$em->remove($type);
			$em->flush();
			$request->getSession()->getFlashBag()->add('success', 'Type bien supprimé.');
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Type non trouvé.');
		}

		return $this->render('AppBundle:Ajax:confirmation.html.twig');
	}

	/**
	* @Route("/type-objet-terrain/add", name="type_objet_terrain_add")
	*/
	public function typeObjetTerrainAddAction(Request $request){

		$type = new TypeObjetTerrain();
		$form = $this->createForm(TypeObjetTerrainType::class, $type);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($type);
			$em->flush();

			$type->uploadLogoPicture();
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('success', 'Type d\'objet terrain bien créé.');

			return $this->redirect($this->generateUrl('type_objet_terrain_edit', array('id' => $type->getId())));
		}

		return $this->render('AppBundle:Enum:add.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Ajouter un type d\'objet terrain'
		));

	}

	/**
	* @Route("/type-objet-terrain/list", name="type_objet_terrain_list")
	*/
	public function typeObjetTerrainListAction(Request $request){

		$em = $this->getDoctrine()->getManager();
		$elements = $em->getRepository('AppBundle:TypeObjetTerrain')->findAll();

		return $this->render('AppBundle:Enum:list.html.twig', array(
			'elements' => $elements,
			'title' => 'Liste des types',
			'route_edit' => 'type_objet_terrain_edit',
			'route_logo' => 'logo_type_objet_terrain',
			'route_delete' => 'type_objet_terrain_delete'
		));

	}

	/**
	* @Route("/type-objet-terrain/edit/{id}", name="type_objet_terrain_edit")
	*/
	public function typeObjetTerrainEditAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:TypeObjetTerrain')->find($id);

		if ($type != null) {
			$form = $this->createForm(TypeObjetTerrainType::class, $type);

			if ($form->handleRequest($request)->isValid()) {
				$type->uploadLogoPicture();
				$em->persist($type);
				$em->flush();
				$request->getSession()->getFlashBag()->add('success', 'Type d\'objet terrain bien edité.');
			}
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Type d\'objet terrain non trouvé.');
			return $this->redirect($this->generateUrl('type_objet_terrain_list'));
		}

		return $this->render('AppBundle:Enum:edit.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Editer un type d\'objet terrain'
		));

	}

	/**
	* @Route("/type-objet-terrain/delete/{id}", name="type_objet_terrain_delete")
	*/
	public function typeObjetTerrainDeleteAction(Request $request, $id){

		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('AppBundle:TypeObjetTerrain')->find($id);

		if ($type != null) {
			$em->remove($type);
			$em->flush();
			$request->getSession()->getFlashBag()->add('success', 'Type bien supprimé.');
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Type non trouvé.');
		}

		return $this->render('AppBundle:Ajax:confirmation.html.twig');
	}


	/**
	* @Route("/message/add", name="message_add")
	*/
	public function messageAddAction(Request $request){

		$message = new Message;
		$form = $this->createForm(MessageType::class, $message);

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
	public function messageListAction(Request $request){

		$em = $this->getDoctrine()->getManager();
		$elements = $em->getRepository('AppBundle:Message')->findAll();

		return $this->render('AppBundle:Enum:list.html.twig', array(
			'elements' => $elements,
			'title' => 'Liste des messages',
			'route_edit' => 'message_edit',
			'route_logo' => false,
			'route_delete' => 'message_delete'
		));

	}

	/**
	* @Route("/message/edit/{id}", name="message_edit")
	*/
	public function messageEditAction(Request $request, $id){
			
		$em = $this->getDoctrine()->getManager();
		$message = $em->getRepository('AppBundle:Message')->find($id);

		if ($message != null) {
			$form = $this->createForm(MessageType::class, $message);

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
		$message = $em->getRepository('AppBundle:Message')->find($id);

		if ($message != null) {
			$em->remove($message);
			$em->flush();
			$request->getSession()->getFlashBag()->add('success', 'Message bien supprimé.');
		} else {
			$request->getSession()->getFlashBag()->add('error', 'Message non trouvé.');
		}

		return $this->redirect($this->generateUrl('message_list'));

	}
}


