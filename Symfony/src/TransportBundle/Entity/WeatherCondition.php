<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use TransportBundle\Entity\TransportProperty;

/**
 * WeatherCondition
 *
 * @ORM\Table(name="weather_condition")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\WeatherConditionRepository")
 */
class WeatherCondition extends TransportProperty
{
    /**
    * @ORM\ManyToOne(targetEntity="AccessRestrictionValue", inversedBy="")
    * @ORM\JoinColumn(nullable=false)
    */
    private $weatherConditionValue;


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

