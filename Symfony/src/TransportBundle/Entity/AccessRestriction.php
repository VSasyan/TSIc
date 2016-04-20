<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use TransportBundle\Entity\TransportProperty;
use NetworkBundle\Entity\NetworkPropertyInit;


/**
 * AccessRestriction
 *
 * @ORM\Table(name="access_restriction")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\AccessRestrictionRepository")
 */
class AccessRestriction extends TransportProperty
{
    use NetworkPropertyInit;

	/**
    * @ORM\ManyToOne(targetEntity="AccessRestrictionValue", inversedBy="")
    * @ORM\JoinColumn(nullable=false)
    */
	protected $restriction;


	/**
	 * Set restriction
	 *
	 * @param AccessRestriction $restriction
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
	 * @return AccessRestriction
	 */
	public function getRestriction()
	{
		return $this->restriction;
	}
}
