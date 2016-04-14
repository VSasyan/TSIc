<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RestrictionForVehicles
 *
 * @ORM\Table(name="restriction_for_vehicles")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\RestrictionForVehiclesRepository")
 */
class RestrictionForVehicles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="measure", type="string", length=255)
     */
    private $measure;

    /**
     * @var string
     *
     * @ORM\Column(name="restrictionType", type="string", length=255)
     */
    private $restrictionType;


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
     * Set measure
     *
     * @param string $measure
     *
     * @return RestrictionForVehicles
     */
    public function setMeasure($measure)
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get measure
     *
     * @return string
     */
    public function getMeasure()
    {
        return $this->measure;
    }

    /**
     * Set restrictionType
     *
     * @param string $restrictionType
     *
     * @return RestrictionForVehicles
     */
    public function setRestrictionType($restrictionType)
    {
        $this->restrictionType = $restrictionType;

        return $this;
    }

    /**
     * Get restrictionType
     *
     * @return string
     */
    public function getRestrictionType()
    {
        return $this->restrictionType;
    }
}
