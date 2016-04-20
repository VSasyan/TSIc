<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * TypeObjetTerrain
 *
 * @ORM\Table(name="type_objet_terrain")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeObjetTerrainRepository")
 */
class TypeObjetTerrain
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
     * @var string
     *
     * @ORM\Column(name="radius", type="integer", options={"default" = 50000})
     */
    private $radius;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\File(maxSize="2048k")
     * @Assert\Image(mimeTypesMessage="Please upload a valid image.")
     */
    protected $logoPictureFile;

    private $tempLogoPicturePath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $logoPicturePath;


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
     * @return Type
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
     * Set description
     *
     * @param string $description
     *
     * @return Type
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Sets the file used for logo picture uploads
     * 
     * @param UploadedFile $file
     * @return object
     */
    public function setLogoPictureFile(UploadedFile $file = null) {
        // set the value of the holder
        $this->logoPictureFile =  $file;
         // check if we have an old image path
        if (isset($this->logoPicturePath)) {
            // store the old name to delete after the update
            $this->tempLogoPicturePath = $this->logoPicturePath;
            $this->logoPicturePath = null;
        } else {
            $this->logoPicturePath = 'initial';
        }
        return $this;
    }

    /**
     * Get the file used for logo picture uploads
     * 
     * @return UploadedFile
     */
    public function getLogoPictureFile() {
        return $this->logoPictureFile;
    }

    /**
     * Set logoPicturePath
     *
     * @param string $logoPicturePath
     * @return User
     */
    public function setLogoPicturePath($logoPicturePath)
    {
        $this->logoPicturePath = $logoPicturePath;
        return $this;
    }

    /**
     * Get logoPicturePath
     *
     * @return string 
     */
    public function getLogoPicturePath()
    {
        return $this->logoPicturePath;
    }

    /**
     * Get the absolute path of the logoPicturePath
     */
    public function getLogoPictureAbsolutePath() {
        return null === $this->logoPicturePath
            ? null
            : $this->getUploadRootDir().'/'.$this->logoPicturePath;
    }

    /**
     * Get root directory for file uploads
     * 
     * @return string
     */
    protected function getUploadRootDir($type='logoPicture') {
        // the absolute directory path where uploaded
        // documents should be saved
        echo(__DIR__.'/../../../upload/logo_type_objet_terrain');
        return __DIR__.'/../../../upload/logo_type_objet_terrain';
    }

    /**
     * Get the web path for the user
     * 
     * @return string
     */
    public function getWebLogoPicturePath() {
        return '/'.$this->getUploadDir().'/'.$this->id.$this->getLogoPicturePath(); 
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUploadLogoPicture() {
        if (null !== $this->getLogoPictureFile()) {
            // a file was uploaded
            // generate a unique filename
            $filename = $this->generateRandomLogoPictureFilename();
            $this->setLogoPicturePath($filename.'.'.$this->getLogoPictureFile()->guessExtension());
        }
    }

    /**
     * Generates a 32 char long random filename
     * 
     * @return string
     */
    public function generateRandomLogoPictureFilename() {
        $count =  0;
        do {
            $generator = new SecureRandom();
            $random = $generator->nextBytes(16);
            $randomString = bin2hex($random);
            $count++;
        }
        while(file_exists($this->getUploadRootDir().'/'.$randomString.'.'.$this->getLogoPictureFile()->guessExtension()) && $count < 50);
        return $randomString;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * 
     * Upload the logo picture
     * 
     * @return mixed
     */
    public function uploadLogoPicture() {
        // check there is a logo pic to upload
        if ($this->getLogoPictureFile() === null) {
            return;
        }
        // check if we have an old image
        if (isset($this->tempLogoPicturePath) && file_exists($this->getUploadRootDir().'/'.$this->tempLogoPicturePath)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->tempLogoPicturePath);
            // clear the temp image path
            $this->tempLogoPicturePath = null;
        }
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->logoPicturePath = $this->getId().'.'.$this->getLogoPictureFile()->guessExtension();
        $this->getLogoPictureFile()->move($this->getUploadRootDir(), $this->logoPicturePath);
        
        $this->logoPictureFile = null;
    }

     /**
     * @ORM\PostRemove()
     */
    public function removeLogoPictureFile()
    {
        if ($file = $this->getLogoPictureAbsolutePath() && file_exists($this->getLogoPictureAbsolutePath())) {
            unlink($file);
        }
    }

    /**
     * Set radius
     *
     * @param integer $radius
     *
     * @return TypeObjetTerrain
     */
    public function setRadius($radius)
    {
        $this->radius = $radius;

        return $this;
    }

    /**
     * Get radius
     *
     * @return integer
     */
    public function getRadius()
    {
        return $this->radius;
    }
}
