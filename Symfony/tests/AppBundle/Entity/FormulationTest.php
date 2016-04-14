<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Particulier;
use AppBundle\Entity\Formulation;
use AppBundle\Entity\Perturbation;
use AppBundle\Entity\TypePerturbation;

class FormulationTest extends WebTestCase
{
	public function setup(){
		$this->formulation = new Formulation();
	}
	public function testSetParticulier()
    {
    	$user = new Particulier();
        $this->formulation->setParticulier($user);
        $this->assertEquals($user, $this->formulation->getParticulier());
    }
    public function testSetName()
    {
    	$this->formulation->setName("perturbation");
    	$this->assertEquals("perturbation", $this->formulation->getName(), 'Failed to set Name.');
    }
    public function testSetDescription()
    {
    	$this->formulation->setDescription("Description");
    	$this->assertEquals("Description", $this->formulation->getDescription(), 'Failed to set description.');
    }
    public function testSetCenter()
    {
    	$this->formulation->setCenter("CenterHere");
    	$this->assertEquals("CenterHere", $this->formulation->getCenter(), 'Failed to set center.');
    }
    public function testSetGeoJSON()
    {
    	$this->formulation->setGeoJSON(
			'"{
			  "type": "Feature",
			  "geometry": {
			    "type": "Point",
			    "coordinates": [125.6, 10.1]
			  },
			  "properties": {
			    "name": "Dinagat Islands"
			  }
			}"'
		);
    	$this->assertEquals(
			'"{
			  "type": "Feature",
			  "geometry": {
			    "type": "Point",
			    "coordinates": [125.6, 10.1]
			  },
			  "properties": {
			    "name": "Dinagat Islands"
			  }
			}"'
		, $this->formulation->getgeoJSON(), 'Failed to set geoJSON.');
    }
    public function testSetCreationDate()
    {
    	$d = new \DateTime();
    	$this->formulation->setCreationDate($d);
    	$this->assertEquals($d, $this->formulation->getCreationDate(), 'Failed to set creationDate.');
    }
    public function testSetBeginDate()
    {
    	$d = new \DateTime();
    	$this->formulation->setBeginDate($d);
    	$this->assertEquals($d, $this->formulation->getBeginDate(), 'Failed to set beginDate.');
    }
    public function testSetEndDate()
    {
    	$d = new \DateTime();
    	$this->formulation->setEndDate($d);
    	$this->assertEquals($d, $this->formulation->getEndDate(), 'Failed to set endDate.');
    }
    public function testSetPerturbation()
    {
    	$perturbation = new Perturbation();
    	$this->formulation->setPerturbation($perturbation);
    	$this->assertEquals($perturbation, $this->formulation->getPerturbation(), 'Failed to set perturbation.');
    }
    public function testSetType()
    {
    	$typePerturbation = new TypePerturbation();
    	$this->formulation->setType($typePerturbation);
    	$this->assertEquals($typePerturbation, $this->formulation->getType(), 'Failed to set typePerturbation.');
    }
    public function testSetValidFormulation()
    {
    	$this->formulation->setValidFormulation(True);
    	$this->assertTrue($this->formulation->getValidFormulation(), 'Failed to set validPerturbation.');
    }
}