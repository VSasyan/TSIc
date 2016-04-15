<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use NetworkBundle\Entity\Node;

/**
 * TransportNode
 */
abstract class TransportNode extends Node
{
    use TransportObject;
}

