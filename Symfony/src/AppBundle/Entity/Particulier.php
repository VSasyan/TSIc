<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
/**
 * particulier
 *
 * @ORM\Table(name="particulier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\particulierRepository")
 */
class Particulier implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="signin_date", type="datetime")
     */
    private $signinDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="activated", type="boolean")
     */
    private $activated;

    /**
    * @ORM\OneToMany(targetEntity="Formulation", mappedBy="particulier")
    * @ORM\JoinColumn(nullable=false)
    */
    private $formulations;

    /**
    * @ORM\OneToMany(targetEntity="Vote", mappedBy="particulier")
    * @ORM\JoinColumn(nullable=false)
    */
    private $votes;

    /**
    * @ORM\OneToOne(targetEntity="Professionnel", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $professionnal;

    /**
    * @ORM\OneToOne(targetEntity="Admin", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $admin;



    /**
    *
    *Implements methods
    *
    *
    */
    public function __construct()
    {
        $this->activated = true;
        $this->signinDate = new \DateTime();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->activated
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->activated
        
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
    /**
    *
    *Methods to Forbid Inactive Users
    *
    *
    */
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->activated;
    }
    /** * ** */

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
     * Set email
     *
     * @param string $email
     *
     * @return particulier
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */    
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return string
     */    
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return particulier
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return particulier
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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return particulier
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set signinDate
     *
     * @param \DateTime $signinDate
     *
     * @return particulier
     */
    public function setSigninDate($signinDate)
    {
        $this->signinDate = $signinDate;

        return $this;
    }

    /**
     * Get signinDate
     *
     * @return \DateTime
     */
    public function getSigninDate()
    {
        return $this->signinDate;
    }

    /**
     * Set activated
     *
     * @param boolean $activated
     *
     * @return particulier
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
     * Add formulation
     *
     * @param \AppBundle\Entity\Formulation $formulation
     *
     * @return Particulier
     */
    public function addFormulation(\AppBundle\Entity\Formulation $formulation)
    {
        $this->formulations[] = $formulation;
        $formulation->setParticulier($this);

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
     * @return Particulier
     */
    public function addVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes[] = $vote;
        $vote->setParticulier($this);

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
     * Set professionnal
     *
     * @param \AppBundle\Entity\Professionnel $professionnal
     *
     * @return Particulier
     */
    public function setProfessionnal(\AppBundle\Entity\Professionnel $professionnal = null)
    {
        $this->professionnal = $professionnal;

        return $this;
    }

    /**
     * Get professionnal
     *
     * @return \AppBundle\Entity\Professionnel
     */
    public function getProfessionnal()
    {
        return $this->professionnal;
    }

    /**
     * Set admin
     *
     * @param \AppBundle\Entity\Admin $admin
     *
     * @return Particulier
     */
    public function setAdmin(\AppBundle\Entity\Admin $admin = null)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return \AppBundle\Entity\Admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }
}
