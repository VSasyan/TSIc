<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Professionnel;

class ProfessionnelTest extends WebTestCase
{
	public function setup(){
		$this->professionnel = new Professionnel();
	}
	public function testSetOrganisation()
    {
        $this->professionnel->setOrganisation('IGN');
        $this->assertEquals('IGN', $this->professionnel->getOrganisation());
    }
    public function testSetPoste()
    {
        $this->professionnel->setPoste('Chef de projet');
        $this->assertEquals('Chef de projet', $this->professionnel->getPoste());
    }
}