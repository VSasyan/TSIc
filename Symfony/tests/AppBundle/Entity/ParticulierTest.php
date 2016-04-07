<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Particulier;
use AppBundle\Entity\Admin;
use AppBundle\Entity\Professionnel;
use AppBundle\Entity\Formulation;

class ParticulierTest extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->user = new Particulier();
	}
	/*
	 * Setters
	 */
    public function testSetUsername()
    {
        $this->user->setUsername("jsmith42");
        $this->assertEquals("jsmith42", $this->user->getUsername());
    }
    public function testSetEmail()
    {
    	$this->user->setEmail("jsmith42@ensg.eu");
    	$this->assertEquals("jsmith42@ensg.eu", $this->user->getEmail());
    }
    public function testSetPassword()
    {
    	$this->user->setPassword("GHTDCdIrA2h-CtBi1");
    	$this->assertEquals("GHTDCdIrA2h-CtBi1", $this->user->getPassword());
    }
    public function testSetName()
    {
    	$this->user->setName("John");
    	$this->assertEquals("John", $this->user->getName());
    }
    public function testSetLastname()
    {
    	$this->user->setLastname("Smith");
    	$this->assertEquals("Smith", $this->user->getLastname());
    }
    public function testSetSigninDate()
    {
    	$d = new \DateTime();
    	$this->user->setSigninDate($d);
    	$this->assertEquals($d, $this->user->getSigninDate());
    }
    public function testSetActivated()
    {
    	$this->user->setActivated(True);
    	$this->assertTRUE($this->user->getActivated());
    }
    /*
     * Professionnal and admin
     */
    public function testSetProfessionnal()
    {
    	$this->userPro = new Particulier();
    	$pro = new Professionnel();
    	$this->userPro->setProfessionnal($pro);
    	$this->assertNotEquals(Null, $this->userPro->getProfessionnal());

    	return($this->userPro);
    }
    public function testSetAdmin()
    {
    	$this->userAdmin = new Particulier();
    	$admin = new Admin();
    	$this->userAdmin->setAdmin($admin);
    	$this->assertNotEquals(Null, $this->userAdmin->getAdmin());

    	return($this->userAdmin);
    }
    /*
     * Role
     */

    /**
     * @depends testSetProfessionnal
     * @depends testSetAdmin
     */
    public function testGetRoles($userPro, $userAdmin){
    	
    	$roleUser = $this->user->getRoles();
    	$rolePro = $userPro->getRoles();
    	$roleAdmin = $userAdmin->getRoles();

    	$this->assertContains('ROLE_USER', $roleUser);
    	$this->assertContains('ROLE_PROFESSIONNAL', $rolePro);
    	$this->assertContains('ROLE_ADMIN', $roleAdmin);
    }
    /*
     * Formulations and votes
     */

    public function testAddFormulation(){
    	$formulation1 = new Formulation();
    	$formulation2 = new Formulation();

    	$this->assertEquals(Null, $this->user->getFormulations());

    	$this->user->addFormulation($formulation1);

    	$this->assertCount(1, $this->user->getFormulations());
    	$this->assertEquals($formulation1, $this->user->getFormulations()[0]);

    	$this->user->addFormulation($formulation2);

    	$this->assertCount(2, $this->user->getFormulations());
    	$this->assertEquals($formulation2, $this->user->getFormulations()[1]);
    }
}
