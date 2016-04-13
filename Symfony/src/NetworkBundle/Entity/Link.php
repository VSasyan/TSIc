<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use NetworkBundle\Entity\GeneralisedLink;

/**
 * Link
 *
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="NetworkBundle\Repository\LinkRepository")
 */
class Link extends GeneralisedLink
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

	/**
	 * Set startNode
	 *
	 * @param \NetworkBundle\Entity\Node $startNode
	 *
	 * @return Link
	 */
	public function setStartNode(\NetworkBundle\Entity\Node $startNode = null)
	{
		$this->startNode = $startNode;

		return $this;
	}

	/**
	 * Get startNode
	 *
	 * @return \NetworkBundle\Entity\Node
	 */
	public function getStartNode()
	{
		return $this->startNode;
	}

	/**
	 * Set endNode
	 *
	 * @param \NetworkBundle\Entity\Node $endNode
	 *
	 * @return Link
	 */
	public function setEndNode(\NetworkBundle\Entity\Node $endNode = null)
	{
		$this->endNode = $endNode;

		return $this;
	}

	/**
	 * Get endNode
	 *
	 * @return \NetworkBundle\Entity\Node
	 */
	public function getEndNode()
	{
		return $this->endNode;
	}
}
