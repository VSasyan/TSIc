<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\TypePerturbation;

class MessageTest extends WebTestCase
{
	public function setup(){
		$this->typePerturbation = new TypePerturbation();
	}
	public function testSetName()
    {
        $this->typePerturbation->setName('nomDuTypeDePerturbation');
        $this->assertEquals('nomDuTypeDePerturbation', $this->typePerturbation->getName());
    }
    public function testSetDescription()
    {
        $this->typePerturbation->setDescription('jeSuisUneDescription');
        $this->assertEquals('jeSuisUneDescription', $this->typePerturbation->getDescription());
    }
    public function testSetLogoPicturePath()
    {
        $this->typePerturbation->setLogoPicturePath('logo_type_perturbation_default.png');
        $this->assertEquals('logo_type_perturbation_default.png', $this->typePerturbation->getLogoPicturePath());

        return($this->typePerturbation);
    }
    /**
     * @depends testSetLogoPicturePath
     */
    public function testGetLogoPictureAbsolutePath($typePerturbation)
    {
    	$this->assertEquals('/home/kh1/Documents/TSIc/Symfony/src/AppBundle/Entity/../../../upload/logo_type_perturbation/logo_type_perturbation_default.png', $typePerturbation->getLogoPictureAbsolutePath());
    }
}