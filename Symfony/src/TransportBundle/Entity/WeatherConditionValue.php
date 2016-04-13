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
     * @var int
     *
     * @ORM\Column(name="id_WeatherConditionValue", type="integer")
     */
    private $idWeatherConditionValue;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * Set idWeatherConditionValue
     *
     * @param integer $idWeatherConditionValue
     *
     * @return WeatherConditionValue
     */
    public function setIdWeatherConditionValue($idWeatherConditionValue)
    {
        $this->idWeatherConditionValue = $idWeatherConditionValue;

        return $this;
    }

    /**
     * Get idWeatherConditionValue
     *
     * @return int
     */
    public function getIdWeatherConditionValue()
    {
        return $this->idWeatherConditionValue;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return WeatherConditionValue
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
}
