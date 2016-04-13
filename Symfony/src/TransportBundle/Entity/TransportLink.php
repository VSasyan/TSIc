<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use NetworkBundle\Entity\Link;

/**
 * TransportLink
 */
abstract class TransportLink extends Link
{
    use TransportObject;
}

