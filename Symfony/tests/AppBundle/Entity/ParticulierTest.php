<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Particulier;
use AppBundle\Entity\Admin;
use AppBundle\Entity\Professionnel;
use AppBundle\Entity\Formulation;
use AppBundle\Entity\Vote;

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
        $this->assertEquals("jsmith42", $this->user->getUsername(), 'Failed to set Username.');
    }
    public function testSetEmail()
    {
    	$this->user->setEmail("jsmith42@ensg.eu");
    	$this->assertEquals("jsmith42@ensg.eu", $this->user->getEmail(), 'Failed to set Email.');
    }
    public function testSetPassword()
    {
    	$this->user->setPassword("GHTDCdIrA2h-CtBi1");
    	$this->assertEquals("GHTDCdIrA2h-CtBi1", $this->user->getPassword(), 'Failed to set Password.');
    }
    public function testSetName()
    {
    	$this->user->setName("John");
    	$this->assertEquals("John", $this->user->getName(), 'Failed to set Name.');
    }
    public function testSetLastname()
    {
    	$this->user->setLastname("Smith");
    	$this->assertEquals("Smith", $this->user->getLastname(), 'Failed to set Lastname.');
    }
    public function testSetSigninDate()
    {
    	$d = new \DateTime();
    	$this->user->setSigninDate($d);
    	$this->assertEquals($d, $this->user->getSigninDate(), 'Failed to set SigninDate.');
    }
    public function testSetActivated()
    {
    	$this->user->setActivated(True);
    	$this->assertTRUE($this->user->getActivated(), 'Failed to set activated.');
    }
    /*
     * Professionnal and admin
     */
    public function testSetProfessionnal()
    {
    	$userPro = new Particulier();
    	$pro = new Professionnel();
    	$userPro->setProfessionnal($pro);
    	$this->assertNotEquals(Null, $userPro->getProfessionnal(), 'Failed to upgrade to professionnal.');

    	return($userPro);
    }
    public function testSetAdmin()
    {
    	$userAdmin = new Particulier();
    	$admin = new Admin();
    	$userAdmin->setAdmin($admin);
    	$this->assertNotEquals(Null, $userAdmin->getAdmin(), 'Failed to upgrade to admin.');

    	return($userAdmin);
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

    	$this->assertContains('ROLE_USER', $roleUser, 'Failed to get the right role of a user.');
    	$this->assertContains('ROLE_PROFESSIONNAL', $rolePro, 'Failed to get the right role of a professionnal.');
    	$this->assertContains('ROLE_ADMIN', $roleAdmin, 'Failed to get the right role of a admin.');
    }
    /*
     * Formulations and votes
     */

    public function testAddFormulation(){
    	$formulation1 = new Formulation();
    	$formulation1->setDescription('blabla1');
    	$formulation2 = new Formulation();
    	$formulation2->setDescription('blabla2');

    	$this->assertTrue($this->user->getFormulations()->isEmpty(), 'Formulations list is not empty when a Particulier is created');

    	$this->user->addFormulation($formulation1);

    	$this->assertCount(1, $this->user->getFormulations(), 'A formulation is not added to attribute formulations with addFormulation.');
    	$this->assertEquals($formulation1, $this->user->getFormulations()[0], 'Formulation is modified when added');

    	$this->user->addFormulation($formulation2);

    	$this->assertCount(2, $this->user->getFormulations(), 'Failed to add a second formulation with addFormualtion');
    	$this->assertEquals($formulation2, $this->user->getFormulations()[1], 'Formulation is modified when added if it s not the first');
    }
    /**
     * @depends testAddFormulation
     */
    public function testRemoveFormulation(){
    	$formulation1 = new Formulation();
    	$formulation1->setDescription('blabla1');
    	$formulation2 = new Formulation();
    	$formulation2->setDescription('blabla2');

    	$this->user->addFormulation($formulation1);
    	$this->user->addFormulation($formulation2);

    	$this->user->removeFormulation($formulation2);

    	$this->assertCount(1, $this->user->getFormulations(), 'Formulation not removed');

    	$this->assertEquals($formulation1, $this->user->getFormulations()[0], 'Other formulations are modified when one is deleted');
    }
    public function testAddVote(){
    	$vote1 = new Vote();
    	$vote2 = new Vote();

    	$this->assertTrue($this->user->getFormulations()->isEmpty(), 'Votes list is not empty when a Particulier is created');

    	$this->user->addVote($vote1);

    	$this->assertCount(1, $this->user->getVotes(), 'A vote is not added to attribute votes with addFormulation.');
    	$this->assertEquals($vote1, $this->user->getVotes()[0], 'Formulation is modified when added');

    	$this->user->addVote($vote2);

    	$this->assertCount(2, $this->user->getVotes(), 'Failed to add a second vote with addVote');
    	$this->assertEquals($vote2, $this->user->getVotes()[1], 'Vote is modified when added if it s not the first');
    }
    /**
     * @depends testAddVote
     */
    public function testRemoveVote(){
    	$vote1 = new Vote();
    	$vote2 = new Vote();

    	$this->user->addVote($vote1);
    	$this->user->addVote($vote2);

    	$this->user->removeVote($vote2);

    	$this->assertCount(1, $this->user->getVotes(), 'Vote not removed');

    	$this->assertEquals($vote1, $this->user->getVotes()[0], 'Other votes are modified when one is deleted');
    }
}
