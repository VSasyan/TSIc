<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TransportObject
 */
trait TransportObject
{
    /**
     * @var string
     *
     * @ORM\Column(name="geographicalName", type="string", length=255, nullable=true)
     */
    protected $geographicalName;


    /**
     * Set geographicalName
     *
     * @param string $geographicalName
     *
     * @return TransportObject
     */
    public function setGeographicalName($geographicalName)
    {
        $this->geographicalName = $geographicalName;

        return $this;
    }

    /**
     * Get geographicalName
     *
     * @return string
     */
    public function getGeographicalName()
    {
        return $this->geographicalName;
    }
}

