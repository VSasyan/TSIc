<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use TransportBundle\Entity\TransportNode;

/**
 * RoadNode
 *
 * @ORM\Table(name="road_node")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\RoadNodeRepository")
 */
class RoadNode extends TransportNode
{
}