<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\DocumentCategoryRepository")
 * @ORM\Table(name="document_categories")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class DocumentCategory implements \JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="name")
     * @JMSSerializer\Expose
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Document", mappedBy="categories")
     * @JMSSerializer\Expose
     * @MaxDepth(2)
     */
    private $documents;

    public function __construct() {
        $this->documents = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return DocumentCategory
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Add documents
     *
     * @param \AppBundle\Entity\Document $documents
     * @return DocumentCategory
     */
    public function addDocument(\AppBundle\Entity\Document $documents) {
        $this->documents[] = $documents;
        return $this;
    }

    /**
     * Remove documents
     *
     * @param \AppBundle\Entity\Document $documents
     */
    public function removeDocument(\AppBundle\Entity\Document $documents) {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments() {
        return $this->documents;
    }

    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'documents' => $this->documents
        ];
    }

    /**
     * @param \AppBundle\Entity\Document $document
     * @return bool
     */
    public function hasDocument(Document $document) {
        return $this->getDocuments()->contains($document);
    }

}
