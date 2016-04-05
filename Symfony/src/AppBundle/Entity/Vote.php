<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
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
    * @ORM\OneToOne(targetEntity="Message", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $message;


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
}

