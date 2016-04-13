<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Node
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
	* @var	\Doctrine\Common\Collections\ArrayCollection
	* @ORM\OneToMany(targetEntity="Link", mappedBy="inspireId")
	* @ORM\JoinTable(name="spokeStart")
	*/

	protected $spokeStart;

	/**
	* @var	\Doctrine\Common\Collections\ArrayCollection
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

	/**
	 * Add spokeStart
	 *
	 * @param \NetworkBundle\Entity\Link $spokeStart
	 *
	 * @return Node
	 */
	public function addSpokeStart(\NetworkBundle\Entity\Link $spokeStart)
	{
		$this->spokeStart[] = $spokeStart;

		return $this;
	}

	/**
	 * Remove spokeStart
	 *
	 * @param \NetworkBundle\Entity\Link $spokeStart
	 */
	public function removeSpokeStart(\NetworkBundle\Entity\Link $spokeStart)
	{
		$this->spokeStart->removeElement($spokeStart);
	}

	/**
	 * Get spokeStart
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getSpokeStart()
	{
		return $this->spokeStart;
	}

	/**
	 * Add spokeEnd
	 *
	 * @param \NetworkBundle\Entity\Link $spokeEnd
	 *
	 * @return Node
	 */
	public function addSpokeEnd(\NetworkBundle\Entity\Link $spokeEnd)
	{
		$this->spokeEnd[] = $spokeEnd;

		return $this;
	}

	/**
	 * Remove spokeEnd
	 *
	 * @param \NetworkBundle\Entity\Link $spokeEnd
	 */
	public function removeSpokeEnd(\NetworkBundle\Entity\Link $spokeEnd)
	{
		$this->spokeEnd->removeElement($spokeEnd);
	}

	/**
	 * Get spokeEnd
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getSpokeEnd()
	{
		return $this->spokeEnd;
	}
}
