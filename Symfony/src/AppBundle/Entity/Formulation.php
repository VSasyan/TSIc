<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formulation
 *
 * @ORM\Table(name="formulation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormulationRepository")
 */
class Formulation
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="center", type="string", length=255)
     */
    private $center;

    /**
     * @var string
     *
     * @ORM\Column(name="geoJSON", type="text")
     */
    private $geoJSON;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="datetime")
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;


    /**
    * @ORM\ManyToOne(targetEntity="Particulier", inversedBy="formulations")
    * @ORM\JoinColumn(nullable=false)
    */
    private $particulier;

    /**
    * @ORM\ManyToOne(targetEntity="Perturbation", inversedBy="formulations")
    * @ORM\JoinColumn(nullable=false)
    */
    private $perturbation;

    /**
    * @ORM\OneToOne(targetEntity="Type", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $type;


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
     * Set name
     *
     * @param string $name
     *
     * @return Formulation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Formulation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set center
     *
     * @param string $center
     *
     * @return Formulation
     */
    public function setCenter($center)
    {
        $this->center = $center;

        return $this;
    }

    /**
     * Get center
     *
     * @return string
     */
    public function getCenter()
    {
        return $this->center;
    }

    /**
     * Set geoJSON
     *
     * @param string $geoJSON
     *
     * @return Formulation
     */
    public function setGeoJSON($geoJSON)
    {
        $this->geoJSON = $geoJSON;

        return $this;
    }

    /**
     * Get geoJSON
     *
     * @return string
     */
    public function getGeoJSON()
    {
        return $this->geoJSON;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Formulation
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

    /**
     * Set beginDate
     *
     * @param \DateTime $beginDate
     *
     * @return Formulation
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Formulation
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set particulier
     *
     * @param \AppBundle\Entity\Particulier $particulier
     *
     * @return Formulation
     */
    public function setParticulier(\AppBundle\Entity\Particulier $particulier)
    {
        $this->particulier = $particulier;

        return $this;
    }

    /**
     * Get particulier
     *
     * @return \AppBundle\Entity\Particulier
     */
    public function getParticulier()
    {
        return $this->particulier;
    }

    /**
     * Set perturbation
     *
     * @param \AppBundle\Entity\Perturbation $perturbation
     *
     * @return Formulation
     */
    public function setPerturbation(\AppBundle\Entity\Perturbation $perturbation)
    {
        $this->perturbation = $perturbation;

        return $this;
    }

    /**
     * Get perturbation
     *
     * @return \AppBundle\Entity\Perturbation
     */
    public function getPerturbation()
    {
        return $this->perturbation;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\Type $type
     *
     * @return Formulation
     */
    public function setType(\AppBundle\Entity\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }
}