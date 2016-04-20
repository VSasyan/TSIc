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
    * @ORM\OneToMany(targetEntity="RoadLink", mappedBy="inspireId")
    * @ORM\JoinTable(name="spokeStart")
    */

    protected $spokeStart;

    /**
    * @var  \Doctrine\Common\Collections\ArrayCollection
    * @ORM\OneToMany(targetEntity="RoadLink", mappedBy="inspireId")
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

    /**
     * Set spokeStart
     *
     * @param Doctrine\Common\Collections\ArrayCollection $spokeStart
     *
     * @return Node
     */
    public function setSpokeStart(Doctrine\Common\Collections\ArrayCollection $spokeStart = null)
    {
        $this->spokeStart = $spokeStart;

        return $this;
    }

    /**
     * Get spokeStart
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getSpokeStart()
    {
        return $this->spokeStart;
    }

    /**
     * Set spokeEnd
     *
     * @param Doctrine\Common\Collections\ArrayCollection $spokeEnd
     *
     * @return Node
     */
    public function setSpokeEnd(Doctrine\Common\Collections\ArrayCollection $spokeEnd = null)
    {
        $this->spokeEnd = $spokeEnd;

        return $this;
    }

    /**
     * Get spokeEnd
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getSpokeEnd()
    {
        return $this->spokeEnd;
    }

    public function __construct() {
        $this->spokeStart = new ArrayCollection();
        $this->spokeEnd = new ArrayCollection();
    }
}

