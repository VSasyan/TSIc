<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 */
class File
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
    * @ORM\ManyToOne(targetEntity="Particulier")
    * @ORM\JoinColumn(nullable=false)
    */
    private $particulier;

    /**
     * @Assert\File(maxSize="8192k")
     * @Assert\File(mimeTypes={
     *      "application/pdf",
     *      "image/jpg",
     *      "image/gif",
     *      "image/jpeg",
     *      "image/png",
     *      "audio/mpeg"
     * })
     */
    protected $fileFile;

    private $tempFilePath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $filePath;


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
     * Sets the file used for logo picture uploads
     * 
     * @param UploadedFile $file
     * @return object
     */
    public function setFileFile(UploadedFile $file = null) {
        // set the value of the holder
        $this->fileFile =  $file;
         // check if we have an old image path
        if (isset($this->filePath)) {
            // store the old name to delete after the update
            $this->tempFilePath = $this->filePath;
            $this->filePath = null;
        } else {
            $this->filePath = 'initial';
        }
        return $this;
    }

    /**
     * Get the file used for logo picture uploads
     * 
     * @return UploadedFile
     */
    public function getFileFile() {
        return $this->fileFile;
    }

    /**
     * Set filePath
     *
     * @param string $filePath
     * @return User
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * Get filePath
     *
     * @return string 
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Get the absolute path of the filePath
     */
    public function getFileAbsolutePath() {
        return null === $this->filePath
            ? null
            : $this->getUploadRootDir().'/'.$this->filePath;
    }

    /**
     * Get root directory for file uploads
     * 
     * @return string
     */
    protected function getUploadRootDir($type='file') {
        // the absolute directory path where uploaded
        // documents should be saved
        echo(__DIR__.'/../../../upload/file');
        return __DIR__.'/../../../upload/file';
    }

    /**
     * Get the web path for the user
     * 
     * @return string
     */
    public function getWebFilePath() {
        return '/'.$this->getUploadDir().'/'.$this->id.$this->getFilePath(); 
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * 
     * Upload the file
     * 
     * @return mixed
     */
    public function uploadFile() {
        // check there is a file to upload
        if ($this->getFileFile() === null) {return;}

        // check if we have an old file
        if (isset($this->tempFilePath) && file_exists($this->getUploadRootDir().'/'.$this->tempFilePath)) {
            // delete the old file
            unlink($this->getUploadRootDir().'/'.$this->tempFilePath);
            // clear the temp file path
            $this->tempFilePath = null;
        }
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->filePath = $this->getId().'.'.$this->getFileFile()->guessExtension();
        $this->getFileFile()->move($this->getUploadRootDir(), $this->filePath);
        
        $this->fileFile = null;
    }

     /**
     * @ORM\PostRemove()
     */
    public function removeFileFile()
    {
        if ($file = $this->getFileAbsolutePath() && file_exists($this->getFileAbsolutePath())) {
            unlink($file);
        }
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set particulier
     *
     * @param \AppBundle\Entity\Particulier $particulier
     *
     * @return File
     */
    public function setParticulier(\AppBundle\Entity\Particulier $particulier)
    {
        $this->particulier = $particulier;

        return $this;
    }

    /**
     * Get particulier
     *
     * @return \AppBundle\Entity\Particulier
     */
    public function getParticulier()
    {
        return $this->particulier;
    }
}
