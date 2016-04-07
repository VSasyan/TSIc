<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Particulier;
use AppBundle\Entity\Admin;
use AppBundle\Entity\Professionnel;

class ParticulierTest extends WebTestCase
{
	/*
	 * Setters
	 */
    public function testSetUsername()
    {
    	$user = new Particulier();
        $user->setUsername("jsmith42");
        $this->assertEquals("jsmith42", $user->getUsername());
    }
    public function testSetEmail()
    {
    	$user = new Particulier();
    	$user->setEmail("jsmith42@ensg.eu");
    	$this->assertEquals("jsmith42@ensg.eu", $user->getEmail());
    }
    public function testSetPassword()
    {
    	$user = new Particulier();
    	$user->setPassword("GHTDCdIrA2h-CtBi1");
    	$this->assertEquals("GHTDCdIrA2h-CtBi1", $user->getPassword());
    }
    public function testSetName()
    {
    	$user = new Particulier();
    	$user->setName("John");
    	$this->assertEquals("John", $user->getName());
    }
    public function testSetLastname()
    {
    	$user = new Particulier();
    	$user->setLastname("Smith");
    	$this->assertEquals("Smith", $user->getLastname());
    }
    public function testSetSigninDate()
    {
    	$user = new Particulier();
    	$d = new \DateTime();
    	$user->setSigninDate($d);
    	$this->assertEquals($d, $user->getSigninDate());
    }
    public function testSetActivated()
    {
    	$user = new Particulier();
    	$user->setActivated(True);
    	$this->assertEquals(True, $user->getActivated());
    }
    /*
     * Professionnal and admin
     */
    public function testSetProfessionnal()
    {
    	$user = new Particulier();
    	$pro = new Professionnel();
    	$user->setProfessionnal($pro);
    	$this->assertNotEquals(Null, $user->getProfessionnal());
    }
    public function testSetAdmin()
    {
    	$user = new Particulier();
    	$admin = new Admin();
    	$user->setAdmin($admin);
    	$this->assertNotEquals(Null, $user->getAdmin());
    }

}
