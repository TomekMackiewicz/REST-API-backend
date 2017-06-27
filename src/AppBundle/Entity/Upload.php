<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Upload
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="upload", fileNameProperty="uploadName", size="uploadSize")
     * 
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $fileName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $fileSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return File
     */
    public function setUploadFile(Upload $upload = null)
    {
        $this->uploadFile = $upload;

        if ($upload) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
        
        return $this;
    }

    /**
     * @return Upload|null
     */
    public function getUploadFile()
    {
        return $this->uploadFile;
    }

    /**
     * @param string $uploadName
     *
     * @return File
     */
    public function setUploadName($uploadName)
    {
        $this->uploadName = $uploadName;
        
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUploadName()
    {
        return $this->uploadName;
    }
    
    /**
     * @param integer $uploadSize
     *
     * @return Upload
     */
    public function setUploadSize($uploadSize)
    {
        $this->uploadSize = $uploadSize;
        
        return $this;
    }

    /**
     * @return integer|null
     */
    public function getUploadSize()
    {
        return $this->uploadSize;
    }
}
