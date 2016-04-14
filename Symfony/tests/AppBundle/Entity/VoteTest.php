<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Particulier;
use AppBundle\Entity\Vote;
use AppBundle\Entity\Perturbation;
use AppBundle\Entity\Message;

class VoteTest extends WebTestCase
{
	public function setup(){
		$this->vote = new Vote();
	}
	public function testSetParticulier()
    {
    	$user = new Particulier();
        $this->vote->setParticulier($user);
        $this->assertEquals($user, $this->vote->getParticulier());
    }
    public function testSetMessage()
    {
        $message = new Message();
    	$this->vote->setMessage($message);
    	$this->assertEquals($message, $this->vote->getMessage(), 'Failed to set message.');
    }
    public function testSetDate()
    {
    	$d = new \DateTime();
    	$this->vote->setDate($d);
    	$this->assertEquals($d, $this->vote->getDate(), 'Failed to set Date.');
    }
    public function testSetPerturbation()
    {
    	$perturbation = new Perturbation();
    	$this->vote->setPerturbation($perturbation);
    	$this->assertEquals($perturbation, $this->vote->getPerturbation(), 'Failed to set perturbation.');
    }
}