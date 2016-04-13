<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use NetworkBundle\Entity\Link;

/**
 * TransportLink
 *
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\TransportLinkRepository")
 */
class TransportLink extends Link
{
    use TransportObject;
}

