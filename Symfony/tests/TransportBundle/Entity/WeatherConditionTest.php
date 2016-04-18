<?php

namespace Tests\TransportBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use TransportBundle\Entity\WeatherCondition;
use TransportBundle\Entity\WeatherConditionValue;

class WeatherConditionTest extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->weatherCondition = new WeatherCondition();
	}
	/*
	 * Setters
	 */
	public function testSetName()
	{
		$name = 'Rain';
		$this->weatherCondition->setName($name);
		$this->assertEquals($name, $this->weatherCondition->getName());
	}
	public function testSetWeatherConditionValue()
	{
		$weatherConditionValue =  new WeatherConditionValue();
		$this->weatherCondition->setWeatherConditionValue($weatherConditionValue);
		$this->assertEquals($weatherConditionValue, $this->weatherConditionValue->getWeatherConditionValue());
	}
}