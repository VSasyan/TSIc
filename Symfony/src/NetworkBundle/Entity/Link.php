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
	 * @ORM\ManyToOne(targetEntity="Node", inversedBy="spokeStart")
	 * @ORM\JoinColumn(name="startNode", referencedColumnName="inspireId")
	 */
	protected $startNode;

	/**
	 * @ORM\ManyToOne(targetEntity="Node", inversedBy="spokeEnd")
	 * @ORM\JoinColumn(name="endNode", referencedColumnName="inspireId")
	 */
	protected $endNode;


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

