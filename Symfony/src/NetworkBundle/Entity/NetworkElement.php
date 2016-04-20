<?php

namespace NetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Element
 */
abstract class NetworkElement
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
     * @ORM\ManyToMany(targetEntity="NetworkBundle\Entity\NetworkProperty")
     * @ORM\JoinTable(name="element_property",
     *      joinColumns={
     *          @ORM\JoinColumn(name="element_id", referencedColumnName="inspireId")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="property_id", referencedColumnName="inspireId", unique=true)
     *      }
     * )
     */
    protected $properties;


    /**
     * Get id
     *
     * @return int
     */
    public function getInspireId()
    {
        return $this->inspireId;
    }


    public function __construct() {
        $this->properties = new ArrayCollection();
    }

    /**
     * Add property
     *
     * @param \NetworkBundle\Entity\NetworkProperty $property
     *
     * @return NetworkElement
     */
    public function addProperty(\NetworkBundle\Entity\NetworkProperty $property)
    {
        $this->properties[] = $property;

        return $this;
    }

    /**
     * Remove property
     *
     * @param \NetworkBundle\Entity\NetworkProperty $property
     */
    public function removeProperty(\NetworkBundle\Entity\NetworkProperty $property)
    {
        $this->properties->removeElement($property);
    }

    /**
     * Get properties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
