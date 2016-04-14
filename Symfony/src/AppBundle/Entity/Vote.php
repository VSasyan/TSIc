<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote", indexes={
 *      @ORM\Index(name="idxUnique", columns={"particulier_id", "perturbation_id", "message_id"})
 * }, uniqueConstraints={
 *      @ORM\UniqueConstraint(name="idxUnique", columns={"particulier_id", "perturbation_id", "message_id"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 */
class Vote
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
    * @ORM\ManyToOne(targetEntity="Message", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $message;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Vote
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set particulier
     *
     * @param \AppBundle\Entity\Particulier $particulier
     *
     * @return Vote
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
     * @return Vote
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
     * Set message
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return Vote
     */
    public function setMessage(\AppBundle\Entity\Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return \AppBundle\Entity\Message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
