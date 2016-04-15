<?php

namespace Tests\TransportBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use TransportBundle\Entity\WeatherCondition;
use TransportBundle\Entity\WeatherConditionValue;

class WeatherConditionValueTest extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->weatherConditionValue = new WeatherCondition();
	}
	/*
	 * Setters
	 */
	public function testSetName()
	{
		$name = 'Rain';
		$this->weatherConditionValue->setName($name);
		$this->assertEquals($name, $this->weatherConditionValue->getName());
	}
}