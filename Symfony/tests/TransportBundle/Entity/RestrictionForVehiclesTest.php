<?php

namespace Tests\TransportBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use TransportBundle\Entity\RestrictionForVehicles;
use TransportBundle\Entity\RestrictionTypeValue;

class AccessRestructionTest extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->restrictionForVehicles = new RestrictionForVehicles();
	}
	/*
	 * Setters
	 */
	public function testSetMeasure()
	{
		$measure = 3.5;
		$this->restrictionForVehicles->setMeasure($measure);
		$this->assertSame($measure, $this->restrictionForVehicles->getMeasure());
	}
	public function testSetRestrictionType()
	{
		$restrictionType = new RestrictionTypeValue();
		$this->restrictionForVehicles->setRestrictionType($restrictionType);
		$this->assertSame($restrictionType, $this->restrictionForVehicles->getRestrictionType());
	}
}