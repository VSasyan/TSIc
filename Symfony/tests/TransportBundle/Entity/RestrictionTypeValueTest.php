<?php

namespace Tests\TransportBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use TransportBundle\Entity\AccessRestrictionValue;

class AccessTypeValueTest extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->restrictionTypeValue = new RestrictionTypeValue();
	}
	/*
	 * Setters
	 */
	public function testSetName()
	{
		$name = 'Width';
		$this->restrictionTypeValue->setName($name);
		$this->assertEquals($name, $this->restrictionTypeValue->getName());
	}
}