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

//    /**
//     * @ORM\Column(type="integer", name="form_id", nullable=true)
//     * @JMSSerializer\Expose
//     */
//    private $formId;    
    
    /**
     * @ORM\Column(type="string", name="title")
     * @JMSSerializer\Expose
     */
    private $title;

    /**
     * @ORM\Column(type="text", name="body")
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
     * @Assert\Date() (
     *  message = "Invalid value (expected: date format)."
     * )
     * @JMSSerializer\Expose
     */
    private $modifiedDate;

    /**
     * @ORM\OneToOne(targetEntity="Form", mappedBy="document")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id", onDelete="SET NULL")
     * @JMSSerializer\Expose
     * @MaxDepth(1)
     */    
    private $form;
    
    public function __construct() {
        $this->addDate = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

//    /**
//     * @return mixed
//     */
//    public function getFormId() {
//        return $this->formId;
//    }

//    /**
//     * @param mixed $formId
//     * @return Document
//     */
//    public function setformId($formId) {
//        $this->formId = $formId;
//        return $this;
//    }    
    
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

    /**
     * @return mixed
     */
    public function getForm() {
        return $this->form;
    }    
    
    /**
     * Add form
     *
     * @param \AppBundle\Entity\Form $form
     * @return Document
     */
    public function addForm(\AppBundle\Entity\Form $form) {
        $this->form = $form;
        return $this;
    }

    /**
     * Remove form
     */
    public function removeForm() {
        $this->form = NULL;
        return $this;            
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
            'modifiedDate' => $this->modifiedDate
        ];
    }

}
