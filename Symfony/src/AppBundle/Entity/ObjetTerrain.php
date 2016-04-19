<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Jsor\Doctrine\PostGIS\Types\PostGISType;

\Doctrine\DBAL\Types\Type::addType("geometry", "Jsor\Doctrine\PostGIS\Types\GeometryType");

/**
 * ObjetTerrain
 *
 * @ORM\Table(name="objet_terrain")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjetTerrainRepository")
 */
class ObjetTerrain
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var geometry
     *
     * @ORM\Column(type="geometry", options={"geometry_type"="POINT", "srid"=4326})
     */
    private $position;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->description = '';
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
     * Set name
     *
     * @param string $name
     *
     * @return ObjetTerrain
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
     * Set type
     *
     * @param integer $type
     *
     * @return ObjetTerrain
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set position
     *
     * @param geometry $position
     *
     * @return ObjetTerrain
     */
    public function setGeometry($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return geometry
     */
    public function getGeometry()
    {
        return $this->position;
    }
}

