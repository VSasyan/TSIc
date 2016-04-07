<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StatutController extends Controller
{
	/*
	 * getCurrentUser
	 *
	 * return the logged user (null there is not logged user)
	*/
	public function getCurrentUser(){
		return $this->container->get('security.token_storage')->getToken()->getUser();
	}

	/*
	 * getCurrentId
	 *
	 * return the id of the logged user or 0 (user->id is always higher than 0).
	*/
	public function getCurrentId(){
		if ($this->isAuth()) {
			return $this->getCurrentUser()->getId();
		} else {return 0;}
	}

	/*
	 * isAuth
	 *
	 * return true if there is a logged user.
	*/
	public function isAuth(){
		return $this->getCurrentUser() != 'anon.';
	}

	/*
	 * isProfessionnel
	 *
	 * return true if the logged user is a Professionnel.
	*/
	public function isProfessionnel() {
		$user = $this->getCurrentUser();
		if ($this->isAuth() && $user != null) {
			if ($user->getProfessionnel() != null) {
				{return true;}
			}
		}
		return false;
	}

	/*
	 * isPro = isProfessionnel
	 *
	 * return true if the logged user is a Professionnel.
	*/
	public function isPro() {
		$user = $this->getCurrentUser();
		if ($this->isAuth() && $user != null) {
			if ($user->getClient() != null) {
				{return true;}
			}
		}
		return false;
	}

	/*
	 * isAdmin
	 *
	 * return true if the logged user is an Admin.
	*/
	public function isAdmin() {
		$user = $this->getCurrentUser();
		if ($this->isAuth() && $user != null) {
			if ($user->getAdmin() != null) {
				{return true;}
			}
		}
		return false;
	}

}
