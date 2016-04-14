<?php

namespace Tests\TransportBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use TransportBundle\Entity\RoadLink;
use TransportBundle\Entity\AccessRestriction;

class RoadLinkTest extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->roadlink = new RoadLink();
	}
	/*
	 * Setters
	 */
	public function testSetGeographicalName()
	{
		$name = "Avenue Médéric";
		$this->roadlink->setGeographicalName($name);
		$this->assertEquals($name, $this->roadlink->getGeographicalName(), 'Failed to set TransportObject:geographicalName.');
	}
	public function testSetCentrelineGeometry()
	{
		$geom = "LINE(POINT(0 0), POINT(1 1))";
		$this->roadlink->setCentreLineGeometry($geom);
		$this->assertEquals($geom, $this->roadlink->getCentrelineGeometry(), 'Failed to set Link:centrelineGeometry.');
	}

    public function testAddProperty()
    {
        $prop = new AccessRestriction;
        $prop->setRestriction("toll");
        $this->roadlink->addProperty($prop);
        $this->assertEquals($prop->getRestriction(), $this->roadlink->getProperties()[0]->getRestriction(), 'Failed to set NetworkElement-AccessProperty.');
    }
}
