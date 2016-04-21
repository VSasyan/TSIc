<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\ObjetTerrain;

class ObjectTerrainTest extends WebTestCase
{
	public function setup(){
		$this->objetTerrain = new ObjetTerrain();
	}
	public function testSetName()
    {
        $this->objetTerrain->setName('nomDuObjetTerrain');
        $this->assertEquals('nomDuObjetTerrain', $this->objetTerrain->getName(), 'Failed to set the objetTerrain name.');
    }
    public function testSetType()
    {
    	$type = 2;
    	$this->objetTerrain->setType($type);
    	$this->assertEquals($type, $this->objetTerrain->getType(), 'Failed to set type.');
    }
    /*public function testSetGeometry()
    {
    	$geometry = new Geometry();
    	$this->objetTerrain->setGeometry($geometry);
    	$this->assertEquals($geometry, $this->objetTerrain->getGeometry(), 'Failed to set geometry.');
    }*/
}