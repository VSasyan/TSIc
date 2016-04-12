<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Perturbation;
use AppBundle\Entity\Formulation;
use AppBundle\Entity\Vote;

class PerturbationTest extends WebTestCase
{
	/*
	 * Setup
	 */
	public function setup(){
		$this->perturbation = new Perturbation();
	}
	/*
	 * Setters
	 */
    public function testSetCreationDate()
    {
    	$d = new \DateTime();
    	$this->perturbation->setCreationDate($d);
    	$this->assertEquals($d, $this->perturbation->getCreationDate(), 'Failed to set CreationDate.');
    }
    public function testSetActivated()
    {
    	$this->perturbation->setActivated(True);
    	$this->assertTRUE($this->perturbation->getActivated(), 'Failed to set activated.');
    }
    public function testSetValid()
    {
        $this->perturbation->setValid(True);
        $this->assertTRUE($this->perturbation->getValid(), 'Failed to set valid.');
    }
    public function testSetArchived()
    {
        $this->perturbation->setArchived(True);
        $this->assertTRUE($this->perturbation->getArchived(), 'Failed to set archived.');
    }
    /*
     * Formulations and votes
     */

    public function testAddFormulation(){
    	$formulation1 = new Formulation();
    	$formulation1->setDescription('blabla1');
    	$formulation2 = new Formulation();
    	$formulation2->setDescription('blabla2');

    	$this->assertTrue($this->perturbation->getFormulations()->isEmpty(), 'Formulations list is not empty when a Perturbation is created');

    	$this->perturbation->addFormulation($formulation1);

    	$this->assertCount(1, $this->perturbation->getFormulations(), 'A formulation is not added to attribute formulations with addFormulation.');
    	$this->assertEquals($formulation1, $this->perturbation->getFormulations()[0], 'Formulation is modified when added');

    	$this->perturbation->addFormulation($formulation2);

    	$this->assertCount(2, $this->perturbation->getFormulations(), 'Failed to add a second formulation with addFormualtion');
    	$this->assertEquals($formulation2, $this->perturbation->getFormulations()[1], 'Formulation is modified when added if it s not the first');
    }
    /**
     * @depends testAddFormulation
     */
    public function testRemoveFormulation(){
    	$formulation1 = new Formulation();
    	$formulation1->setDescription('blabla1');
    	$formulation2 = new Formulation();
    	$formulation2->setDescription('blabla2');

    	$this->perturbation->addFormulation($formulation1);
    	$this->perturbation->addFormulation($formulation2);

    	$this->perturbation->removeFormulation($formulation2);

    	$this->assertCount(1, $this->perturbation->getFormulations(), 'Formulation not removed');

    	$this->assertEquals($formulation1, $this->perturbation->getFormulations()[0], 'Other formulations are modified when one is deleted');
    }
    public function testAddVote(){
    	$vote1 = new Vote();
    	$vote2 = new Vote();

    	$this->assertTrue($this->perturbation->getFormulations()->isEmpty(), 'Votes list is not empty when a Perturbation is created');

    	$this->perturbation->addVote($vote1);

    	$this->assertCount(1, $this->perturbation->getVotes(), 'A vote is not added to attribute votes with addFormulation.');
    	$this->assertEquals($vote1, $this->perturbation->getVotes()[0], 'Formulation is modified when added');

    	$this->perturbation->addVote($vote2);

    	$this->assertCount(2, $this->perturbation->getVotes(), 'Failed to add a second vote with addVote');
    	$this->assertEquals($vote2, $this->perturbation->getVotes()[1], 'Vote is modified when added if it s not the first');
    }
    /**
     * @depends testAddVote
     */
    public function testRemoveVote(){
    	$vote1 = new Vote();
    	$vote2 = new Vote();

    	$this->perturbation->addVote($vote1);
    	$this->perturbation->addVote($vote2);

    	$this->perturbation->removeVote($vote2);

    	$this->assertCount(1, $this->perturbation->getVotes(), 'Vote not removed');

    	$this->assertEquals($vote1, $this->perturbation->getVotes()[0], 'Other votes are modified when one is deleted');
    }
}
