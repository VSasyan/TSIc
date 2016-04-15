<?php

namespace Tests\TransportBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use TransportBundle\Entity\AccessRestriction;
use TransportBundle\Entity\AccessRestrictionValue;

class AccessRestructionTest extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->accessRestriction = new AccessRestriction();
	}
	/*
	 * Setters
	 */
	public function testSetRestriction()
	{
		$restriction = new AccessRestrictionValue();
		$this->accessRestriction->setRestriction($restriction);
		$this->assertEquals($restriction, $this->accessRestriction->getRestriction());
	}
}