<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use TransportBundle\Entity\TransportNode;

/**
 * RoadNode
 *
 * @ORM\Table(name="road_node")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\RoadNodeRepository")
 */
class RoadNode extends TransportNode
{
	/**
    * @ORM\ManyToOne(targetEntity="FormOfRoadNodeValue", inversedBy="")
    * @ORM\JoinColumn(nullable=true)
    */
	private $formOfRoadNode;

    /**
     * Set formOfRoadNode
     *
     * @param \TransportBundle\Entity\FormOfRoadNodeValue $formOfRoadNode
     *
     * @return RoadNode
     */
    public function setFormOfRoadNode(\TransportBundle\Entity\FormOfRoadNodeValue $formOfRoadNode)
    {
        $this->formOfRoadNode = $formOfRoadNode;

        return $this;
    }

    /**
     * Get formOfRoadNode
     *
     * @return \TransportBundle\Entity\FormOfRoadNodeValue
     */
    public function getFormOfRoadNode()
    {
        return $this->formOfRoadNode;
    }

    /**
     * Add spokeStart
     *
     * @param \TransportBundle\Entity\RoadLink $spokeStart
     *
     * @return RoadNode
     */
    public function addSpokeStart(\TransportBundle\Entity\RoadLink $spokeStart)
    {
        $this->spokeStart[] = $spokeStart;

        return $this;
    }

    /**
     * Remove spokeStart
     *
     * @param \TransportBundle\Entity\RoadLink $spokeStart
     */
    public function removeSpokeStart(\TransportBundle\Entity\RoadLink $spokeStart)
    {
        $this->spokeStart->removeElement($spokeStart);
    }

    /**
     * Add spokeEnd
     *
     * @param \TransportBundle\Entity\RoadLink $spokeEnd
     *
     * @return RoadNode
     */
    public function addSpokeEnd(\TransportBundle\Entity\RoadLink $spokeEnd)
    {
        $this->spokeEnd[] = $spokeEnd;

        return $this;
    }

    /**
     * Remove spokeEnd
     *
     * @param \TransportBundle\Entity\RoadLink $spokeEnd
     */
    public function removeSpokeEnd(\TransportBundle\Entity\RoadLink $spokeEnd)
    {
        $this->spokeEnd->removeElement($spokeEnd);
    }
}
