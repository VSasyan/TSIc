<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * NetworkProperty
 *
 * @ORM\MappedSuperclass
 * All attributes have to be private.
 * stackoverflow.com/questions/25749418/
 */
abstract class NetworkProperty
{
    /**
	 * @var int
	 *
	 * @ORM\Column(name="inspireId", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $inspireId;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="beginLifespanVersion", type="datetime", nullable=true)
	 */
	protected $beginLifespanVersion;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="endLifespanVersion", type="datetime", nullable=true)
	 */
	protected $endLifespanVersion;


	/**
	 * Get inspireId
	 *
	 * @return int
	 */
	public function getInspireId()
	{
		return $this->inspireId;
	}

	/**
	 * Set beginLifespanVersion
	 *
	 * @param \DateTime $beginLifespanVersion
	 *
	 * @return NetworkProperty
	 */
	public function setBeginLifespanVersion($beginLifespanVersion)
	{
		$this->beginLifespanVersion = $beginLifespanVersion;

		return $this;
	}

	/**
	 * Get beginLifespanVersion
	 *
	 * @return \DateTime
	 */
	public function getBeginLifespanVersion()
	{
		return $this->beginLifespanVersion;
	}

	/**
	 * Set endLifespanVersion
	 *
	 * @param \DateTime $endLifespanVersion
	 *
	 * @return NetworkProperty
	 */
	public function setEndLifespanVersion($endLifespanVersion)
	{
		$this->endLifespanVersion = $endLifespanVersion;

		return $this;
	}

	/**
	 * Get endLifespanVersion
	 *
	 * @return \DateTime
	 */
	public function getEndLifespanVersion()
	{
		return $this->endLifespanVersion;
	}
}
