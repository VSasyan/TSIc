<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Node
 *
 * @ORM\Table(name="node")
 * @ORM\Entity(repositoryClass="NetworkBundle\Repository\NodeRepository")
 */
class Node extends Element
{
    /**
     * @var string
     *
     * @ORM\Column(name="geometry", type="string", length=255)
     */
    private $geometry;

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

