<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use NetworkBundle\Entity\GeneralisedLink;

/**
 * Link
 */
abstract class Link extends GeneralisedLink
{
    /**
     * @var string
     *
     * @ORM\Column(name="centrelineGeometry", type="string", length=4096, nullable=true)
     */
    private $centrelineGeometry;


    /**
     * Set centrelineGeometry
     *
     * @param string $centrelineGeometry
     *
     * @return Link
     */
    public function setCentrelineGeometry($centrelineGeometry)
    {
        $this->centrelineGeometry = $centrelineGeometry;

        return $this;
    }

    /**
     * Get centrelineGeometry
     *
     * @return string
     */
    public function getCentrelineGeometry()
    {
        return $this->centrelineGeometry;
    }
}

