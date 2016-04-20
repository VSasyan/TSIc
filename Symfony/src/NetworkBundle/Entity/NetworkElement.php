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

}
