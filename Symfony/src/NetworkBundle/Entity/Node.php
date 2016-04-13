<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Node
 *
 * @ORM\Table(name="node")
 * @ORM\Entity(repositoryClass="NetworkBundle\Repository\NodeRepository")
 */
abstract class Node extends Element
{
    /**
     * @var string
     *
     * @ORM\Column(name="geometry", type="string", length=255)
     */
    private $geometry;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

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
}

