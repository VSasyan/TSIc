<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use NetworkBundle\Entity\Element;

/**
 * GeneralisedLink
 *
 * @ORM\Entity(repositoryClass="NetworkBundle\Repository\GeneralisedLinkRepository")
 */
class GeneralisedLink extends Element
{
    /**
     * @var int
     *
     * @ORM\Column(name="toto", type="integer")
     */
    private $toto;


    /**
     * Get toto
     *
     * @return int
     */
    public function getToto()
    {
        return $this->toto;
    }

    /**
     * Set toto
     *
     * @param int $toto
     *
     * @return GeneralisedLink
     */
    public function setToto($toto)
    {
        $this->toto = $toto;

        return $this;
    }
}

