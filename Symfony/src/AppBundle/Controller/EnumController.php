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
	public function typeAddAction(){

		return new Response('<html><body>typeAddAction!</body></html>');

	}

	/**
    * @Route("/type/edit/{id}", name="type_edit")
    */
	public function typeEditAction($id){

		return new Response('<html><body>typeEditAction!</body></html>');

	}

	/**
    * @Route("/type/delete/{id}", name="type_delete")
    */
	public function typeDeleteAction($id){

		return new Response('<html><body>typeDeleteAction!</body></html>');

	}

	/**
    * @Route("/message/add", name="message_add")
    */
	public function messageAddAction(){

		return new Response('<html><body>messageAddAction!</body></html>');

	}


	/**
    * @Route("/message/edit/{id}", name="message_edit")
    */
	public function messageEditAction($id){

		return new Response('<html><body>messageEditAction!</body></html>');

	}


	/**
    * @Route("/message/delete/{id}", name="message_delete")
    */
	public function messageDeleteAction($id){

		return new Response('<html><body>messageDeleteAction!</body></html>');

	}


}


