<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use NetworkBundle\Entity\NetworkElement;

/**
 * Node
 */
abstract class Node extends NetworkElement
{
    /**
     * @var string
     *
     * @ORM\Column(name="geometry", type="string", length=255)
     */
    protected $geometry;

    /**
    * @var  \Doctrine\Common\Collections\ArrayCollection
    * @ORM\OneToMany(targetEntity="Link", mappedBy="inspireId")
    * @ORM\JoinTable(name="spokeStart")
    */

    protected $spokeStart;

    /**
    * @var  \Doctrine\Common\Collections\ArrayCollection
    * @ORM\OneToMany(targetEntity="Link", mappedBy="inspireId")
    * @ORM\JoinTable(name="spokeEnd")
    */

    protected $spokeEnd;

    /**
     * Set geometry
     *
     * @param string $geometry
     *
     * @return Node
     */
    public function setGeometry($geometry)
    {
        $this->geometry = $geometry;

        return $this;
    }

    /**
     * Get geometry
     *
     * @return string
     */
    public function getGeometry()
    {
        return $this->geometry;
    }

    public function __construct() {
        $this->spokeStart = new ArrayCollection();
        $this->spokeEnd = new ArrayCollection();
    }
}

