<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoadNode
 *
 * @ORM\Table(name="road_node")
 * @ORM\Entity(repositoryClass="NetworkBundle\Repository\RoadNodeRepository")
 */
class RoadNode extends TransportNode
{
}

