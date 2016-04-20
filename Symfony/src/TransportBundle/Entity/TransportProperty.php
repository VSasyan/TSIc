<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use NetworkBundle\Entity\NetworkProperty;



/**
 * TransportProperty
 *
 * @ORM\MappedSuperclass
 */
abstract class TransportProperty extends NetworkProperty
{
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="validFrom", type="datetime", nullable=true)
	 */
	protected $validFrom;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="validTo", type="datetime", nullable=true)
	 */
	protected $validTo;



	/**
	 * Set validFrom
	 *
	 * @param \DateTime $validFrom
	 *
	 * @return TransportProperty
	 */
	public function setValidFrom($validFrom)
	{
		$this->validFrom = $validFrom;

		return $this;
	}

	/**
	 * Get validFrom
	 *
	 * @return \DateTime
	 */
	public function getValidFrom()
	{
		return $this->validFrom;
	}

	/**
	 * Set validTo
	 *
	 * @param \DateTime $validTo
	 *
	 * @return TransportProperty
	 */
	public function setValidTo($validTo)
	{
		$this->validTo = $validTo;

		return $this;
	}

	/**
	 * Get validTo
	 *
	 * @return \DateTime
	 */
	public function getValidTo()
	{
		return $this->validTo;
	}
}

