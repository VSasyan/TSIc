<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeatherConditionValue
 *
 * @ORM\Table(name="weather_condition_value")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\WeatherConditionValueRepository")
 */
class WeatherConditionValue
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
    * @ORM\ManyToOne(targetEntity="WeatherCondition", inversedBy="")
    * @ORM\JoinColumn(nullable=false)
    */
    private $weatherCondition;


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
     * @return WeatherConditionValue
     */
    public function setName($weatherCondition)
    {
        $this->weatherCondition= $weatherCondition;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getweatherCondition()
    {
        return $this->weatherCondition;
    }
}
