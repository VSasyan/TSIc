<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perturbation
 *
 * @ORM\Table(name="perturbation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerturbationRepository")
 */
class Perturbation
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
     * @var bool
     *
     * @ORM\Column(name="activated", type="boolean")
     */
    private $activated;

    /**
     * @var bool
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid;

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;


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
     * Set activated
     *
     * @param boolean $activated
     *
     * @return Perturbation
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * Get activated
     *
     * @return bool
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     *
     * @return Perturbation
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return bool
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     *
     * @return Perturbation
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return bool
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Perturbation
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
}

