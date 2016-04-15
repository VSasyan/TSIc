<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use TransportBundle\Entity\TransportProperty;

/**
 * RestrictionForVehicles
 *
 * @ORM\Table(name="restriction_for_vehicles")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\RestrictionForVehiclesRepository")
 */
class RestrictionForVehicles extends TransportProperty
{
	/**
	 * @var float
	 *
	 * @ORM\Column(name="measure", type="float")
	 */
	private $measure;

	/**
    * @ORM\ManyToOne(targetEntity="RestrictionTypeValue", inversedBy="")
    * @ORM\JoinColumn(nullable=false)
    */
	private $restrictionType;


	/**
	 * Set measure
	 *
	 * @param float $measure
	 *
	 * @return float
	 */
	public function setMeasure($measure)
	{
		$this->measure = $measure;

		return $this;
	}

	/**
	 * Get measure
	 *
	 * @return float
	 */
	public function getMeasure()
	{
		return $this->measure;
	}

	/**
	 * Set restrictionType
	 *
	 * @param RestrictionForVehicles $restrictionType
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
	 * @return RestrictionForVehicles
	 */
	public function getRestrictionType()
	{
		return $this->restrictionType;
	}
}
