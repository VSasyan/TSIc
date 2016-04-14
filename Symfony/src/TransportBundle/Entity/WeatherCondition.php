<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeatherCondition
 *
 * @ORM\Table(name="weather_condition")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\WeatherConditionRepository")
 */
class WeatherCondition
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
    * @ORM\ManyToOne(targetEntity="AccessRestrictionValue", inversedBy="")
    * @ORM\JoinColumn(nullable=false)
    */
    private $weatherConditionValue;



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
     * @return WeatherCondition
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
     * Set weatherConditionValue
     *
     * @param weatherConditionValue $weatherConditionValue
     *
     * @return RestrictionForVehicles
     */
    public function setweatherConditionValue($weatherConditionValue)
    {
        $this->$weatherConditionValue= $$weatherConditionValue;

        return $this;
    }



    /**
     * Get weatherConditionValue
     *
     * @return weatherConditionValue
     */
    public function getweatherConditionValue()
    {
        return $this->$weatherConditionValue;
    }
}

