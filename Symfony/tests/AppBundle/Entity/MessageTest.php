<?php

namespace Tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Message;

class MessageTest extends WebTestCase
{
	public function setup(){
		$this->message = new Message();
	}
	public function testSetName()
    {
        $this->message->setName('nomDuMessage');
        $this->assertEquals('nomDuMessage', $this->message->getName());
    }
}