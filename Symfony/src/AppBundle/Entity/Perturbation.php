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
     * @ORM\Column(name="terminated", type="boolean")
     */
    private $terminated;

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
    * @ORM\OneToMany(targetEntity="Formulation", mappedBy="perturbation")
    * @ORM\JoinColumn(nullable=false)
    */
    private $formulations;

    /**
    * @ORM\OneToMany(targetEntity="Vote", mappedBy="perturbation")
    * @ORM\JoinColumn(nullable=false)
    */
    private $votes;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->formulations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();

        $this->activated = true;
        $this->valid = false;
        $this->terminated = false;
        $this->archived = false;
        $this->creationDate = new \DateTime();
    }


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

    /**
     * Add formulation
     *
     * @param \AppBundle\Entity\Formulation $formulation
     *
     * @return Perturbation
     */
    public function addFormulation(\AppBundle\Entity\Formulation $formulation)
    {
        $this->formulations[] = $formulation;
        $formulation->setPerturbation($this);

        return $this;
    }

    /**
     * Remove formulation
     *
     * @param \AppBundle\Entity\Formulation $formulation
     */
    public function removeFormulation(\AppBundle\Entity\Formulation $formulation)
    {
        $this->formulations->removeElement($formulation);
    }

    /**
     * Get formulations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormulations()
    {
        return $this->formulations;
    }

    /**
     * Add vote
     *
     * @param \AppBundle\Entity\Vote $vote
     *
     * @return Perturbation
     */
    public function addVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes[] = $vote;
        $vote->setPerturbation($this);

        return $this;
    }

    /**
     * Remove vote
     *
     * @param \AppBundle\Entity\Vote $vote
     */
    public function removeVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes->removeElement($vote);
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * return Virtual Pertubation
     * cette fonction récupère un tableau des plus proches
     * perturbations et retourne les dernières formulations
     * correspondant aux perturbations
     * Pertubation------[Formulations] ====> [virtualPerturbation]
     */
    public function returnVirtualPerturbation()
    {
        //tableau des résultats
        $virtualPerturbation = array();
            
        $formulations = $this->getFormulations();
        foreach ($formulations as $f) {
           
            if ($f->getValidFormulation()) {
                $virtualPerturbation['id'] = $f->getId();
                $virtualPerturbation['name'] = $f->getName();
                $virtualPerturbation['type'] = $f->getType();
                $virtualPerturbation['geoJSON'] = $f->getGeoJSON();
                $virtualPerturbation['center'] = $f->getCenter();
                return $virtualPerturbation;
            }
        }

        return false;

    }

    /**
     * Set terminated
     *
     * @param boolean $terminated
     *
     * @return Perturbation
     */
    public function setTerminated($terminated)
    {
        $this->terminated = $terminated;

        return $this;
    }

    /**
     * Get terminated
     *
     * @return boolean
     */
    public function getTerminated()
    {
        return $this->terminated;
    }
}
