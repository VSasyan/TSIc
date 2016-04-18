<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perturbation
 *
 * @ORM\Table(name="perturbation_file")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerturbationFileRepository")
 */
class PerturbationFile
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
    * @ORM\ManyToOne(targetEntity="Perturbation", inversedBy="files")
    * @ORM\JoinColumn(nullable=false)
    */
    private $perturbation;

    /**
    * @ORM\OneToOne(targetEntity="File", cascade={"persist"})
    */
    private $file;

    
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set perturbation
     *
     * @param \AppBundle\Entity\Perturbation $perturbation
     *
     * @return PerturbationFile
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
     * Set file
     *
     * @param \AppBundle\Entity\File $file
     *
     * @return PerturbationFile
     */
    public function setFile(\AppBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \AppBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }
}
