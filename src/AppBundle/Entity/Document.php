<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="integer", name="form_id")
     * @JMSSerializer\Expose
     */
    private $formId;    
    
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime", nullable=true)
     * @Assert\Date()(
     *  message = "Invalid value (expected: date format)."
     * )
     * @JMSSerializer\Expose
     */
    private $addDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
     * @Assert\Date()(
     *  message = "Invalid value (expected: date format)."
     * )
     * @JMSSerializer\Expose
     */
    private $modifiedDate;

//    /**
//     * @ORM\OneToOne(targetEntity="Form")
//     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
//     * @JMSSerializer\Expose
//     */
//    private $form;    
    
    /**
     * @ORM\ManyToMany(targetEntity="DocumentCategory", inversedBy="documents")
     * @ORM\JoinTable(
     *  name="document_category",
     *  joinColumns={
     *      @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="document_category_id", referencedColumnName="id")
     *  }
     * )
     * @JMSSerializer\Expose
     * @MaxDepth(2)
     */
    private $categories;

    public function __construct() {
        $this->addDate = new \DateTime();
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
    public function getFormId() {
        return $this->formId;
    }

    /**
     * @param mixed $formId
     * @return Document
     */
    public function setformId($formId) {
        $this->formId = $formId;
        return $this;
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
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Document
     */
    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
        return $this;
    }

//    /**
//     * Get addDate
//     *
//     * @return \DateTime
//     */
//    public function getAddDate()
//    {
//        return $this->addDate;
//    }

//    /**
//     * Add Form
//     *
//     * @param \AppBundle\Entity\Form $form
//     * @return Document
//     */
//    public function addForm(\AppBundle\Entity\Form $form) {
//        $this->form = $form;
//        return $this;
//    }
//
//    /**
//     * Get Form
//     *
//     * @return Form
//     */
//    public function getForm() {
//        return $this->form;
//    }    
    
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

    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'addDate' => $this->addDate,
            'modifiedDate' => $this->modifiedDate,
            'categories' => $this->categories
        ];
    }

    /**
     * @param \AppBundle\Entity\DocumentCategory $category
     * @return bool
     */
    public function hasCategory(DocumentCategory $category) {
        return $this->getCategories()->contains($category);
    }

}
