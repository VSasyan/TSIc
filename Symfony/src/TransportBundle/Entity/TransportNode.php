<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NetworkBundle\Entity\Node;

/**
 * TrasportNode
 */
absract class TransportNode extends Node
{
    use TransportObject;
}

