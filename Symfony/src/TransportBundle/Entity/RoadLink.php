<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use TransportBundle\Entity\TransportLink;

/**
 * RoadLink
 *
 * @ORM\Table(name="road_link")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\RoadLinkRepository")
 */
class RoadLink extends TransportLink
{
}
