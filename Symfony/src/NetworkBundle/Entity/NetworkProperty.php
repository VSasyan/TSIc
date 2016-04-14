<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NetworkProperty
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
	protected $inspireId;

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
     * @ORM\ManyToOne(targetEntity="NetworkElement", inversedBy="properties")
     * @ORM\JoinColumn(name="element_id", referencedColumnName="inspireId")
     */
    protected $element;

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

    /**
     * Set element
     *
     * @param \NetworkBundle\Entity\NetworkElement $element
     *
     * @return NetworkProperty
     */
    public function setElement(\NetworkBundle\Entity\NetworkElement $element = null)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get element
     *
     * @return \NetworkBundle\Entity\NetworkElement
     */
    public function getElement()
    {
        return $this->element;
    }
}
