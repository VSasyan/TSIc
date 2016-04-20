<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use TransportBundle\Entity\TransportProperty;
use NetworkBundle\Entity\NetworkPropertyInit;

/**
 * WeatherCondition
 *
 * @ORM\Table(name="weather_condition")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\WeatherConditionRepository")
 */
class WeatherCondition extends TransportProperty
{
    use NetworkPropertyInit;

    /**
    * @ORM\ManyToOne(targetEntity="WeatherConditionValue", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $weatherConditionValue;

    /**
     * Set weatherConditionValue
     *
     * @param weatherConditionValue $weatherConditionValue
     *
     * @return WeatherConditionValue
     */
    public function setweatherConditionValue($weatherConditionValue)
    {
        $this->weatherConditionValue=$weatherConditionValue;

        return $this;
    }



    /**
     * Get weatherConditionValue
     *
     * @return WeatherConditionValue
     */
    public function getweatherConditionValue()
    {
        return $this->weatherConditionValue;
    }
}

