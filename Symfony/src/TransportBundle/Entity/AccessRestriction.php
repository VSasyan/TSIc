<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccessRestriction
 *
 * @ORM\Table(name="access_restriction")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\AccessRestrictionRepository")
 */
class AccessRestriction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_AccessRestriction", type="integer")
     */
    private $idAccessRestriction;

    /**
     * @var string
     *
     * @ORM\Column(name="restriction", type="string", length=255)
     */
    private $restriction;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idAccessRestriction
     *
     * @param integer $idAccessRestriction
     *
     * @return AccessRestriction
     */
    public function setIdAccessRestriction($idAccessRestriction)
    {
        $this->idAccessRestriction = $idAccessRestriction;

        return $this;
    }

    /**
     * Get idAccessRestriction
     *
     * @return int
     */
    public function getIdAccessRestriction()
    {
        return $this->idAccessRestriction;
    }

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
