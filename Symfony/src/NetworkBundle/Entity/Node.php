<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

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
    * @var  ArrayCollection
    * @ORM\OneToMany(targetEntity="RoadLink", mappedBy="inspireId")
    * @ORM\JoinTable(name="spokeStart")
    */

    protected $spokeStart;

    /**
    * @var  ArrayCollection
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
     * @param ArrayCollection $spokeStart
     *
     * @return Node
     */
    public function setSpokeStart(ArrayCollection $spokeStart = null)
    {
        $this->spokeStart = $spokeStart;

        return $this;
    }

    /**
     * Get spokeStart
     *
     * @return ArrayCollection
     */
    public function getSpokeStart()
    {
        return $this->spokeStart;
    }

    /**
     * Set spokeEnd
     *
     * @param ArrayCollection $spokeEnd
     *
     * @return Node
     */
    public function setSpokeEnd(ArrayCollection $spokeEnd = null)
    {
        $this->spokeEnd = $spokeEnd;

        return $this;
    }

    /**
     * Get spokeEnd
     *
     * @return ArrayCollection
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

