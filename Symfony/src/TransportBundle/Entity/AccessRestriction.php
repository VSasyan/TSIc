<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use TransportBundle\Entity\TransportProperty;

/**
 * AccessRestriction
 *
 * @ORM\Table(name="access_restriction")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\AccessRestrictionRepository")
 */
class AccessRestriction extends TransportProperty
{
	/**
	 * @var string
	 *
	 * @ORM\Column(name="restriction", type="string", length=255)
	 */
	protected $restriction;


	/**
	 * Set restriction
	 *
	 * @param string $restriction
	 *
	 * @return AccessRestriction
	 */
	public function setRestriction($restriction)
	{
		$this->restriction = $restriction;

		return $this;
	}

	/**
	 * Get restriction
	 *
	 * @return string
	 */
	public function getRestriction()
	{
		return $this->restriction;
	}
}
