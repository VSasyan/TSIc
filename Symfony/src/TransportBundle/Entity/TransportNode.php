<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NetworkBundle\Entity\Node;

/**
 * TrasportNode
 *
 * @ORM\Table(name="trasport_node")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\TrasportNodeRepository")
 */
absract class TransportNode extends Node
{
    use TransportObject;
}

