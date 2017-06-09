<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\DocumentRepository")
 * @ORM\Table(name="documents")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Document implements \JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="title")
     * @JMSSerializer\Expose
     */
    private $title;

    /**
     * @ORM\Column(type="string", name="body")
     * @JMSSerializer\Expose
     */
    private $body;

    /**
     * @ORM\ManyToMany(targetEntity="DocumentCategory", inversedBy="documents")
     * @ORM\JoinTable(name="document_category")
     * @JMSSerializer\Expose
     */
    private $categories;

    public function __construct() {
        $this->categories = new ArrayCollection();
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
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Document
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Document
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    /**
     * Add categories
     *
     * @param \AppBundle\Entity\DocumentCategory $categories
     * @return Document
     */
    public function addCategory(\AppBundle\Entity\DocumentCategory $categories) {
        $this->categories[] = $categories;
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \AppBundle\Entity\DocumentCategory $categories
     */
    public function removeCategory(\AppBundle\Entity\DocumentCategory $categories) {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories() {
        return $this->categories;
    }

//    public function __toString() {
//        return $this->name;
//    }

    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'categories' => $this->categories
        ];
    }

}
