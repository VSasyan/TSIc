<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Particulier;
use AppBundle\Entity\Formulation;

class FormulationTest extends WebTestCase
{
	public function testSetParticulier()
    {
    	$formulation = new Formulation();
    	$user = new Particulier();
        $formulation->setParticulier($user);
        $this->assertEquals($user, $formulation->getParticulier());
    }
}