<?php

namespace Tests\TransportBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use TransportBundle\Entity\AccessRestrictionValue;

class AccessRestrictionTestValue extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->accessRestrictionValue = new AccessRestrictionValue();
	}
	/*
	 * Setters
	 */
	public function testSetName()
	{
		$this->accessRestrictionValue->setName('Legaly Forbidden');
		$this->assertEquals('Legaly Forbidden', $this->accessRestrictionValue->getName());
	}
}