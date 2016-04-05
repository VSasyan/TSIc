<?php

namespace AppBundle\Controller;

use SearchBundle\Entity\Particulier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EnumController extends Controller {

	/**
    @Route("/type/add")
    */

	public function typeAddAction(){

		return new Response('<html><body>Salut!</body></html>');

	}

	/**
    @Route("/type/edit/{id}")
    */

	public function typeEditAction($id){

		return new Response('<html><body>Salut!</body></html>');

	}

	/**
    @Route("/type/delete/{id}")
    */

	public function typeDeleteAction($id){

		return new Response('<html><body>Salut!</body></html>');

	}

	/**
    @Route("/message/add")
    */

	public function messageAddAction(){

		return new Response('<html><body>Salut!</body></html>');

	}


	/**
    @Route("/message/edit/{id}")
    */

	public function messageEditAction($id){

		return new Response('<html><body>Salut!</body></html>');

	}


	/**
    @Route("/message/delete/{id}")
    */

	public function messageDeleteAction($id){

		return new Response('<html><body>Salut!</body></html>');

	}


}


