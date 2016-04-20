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
<<<<<<< HEAD
	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;



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
=======
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
>>>>>>> 1bf6482940389076a985e334006bd7f46cee12e3
}

