<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\QuestionRepository")
 * @ORM\Table(name="questions")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Question implements \JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="sequence", nullable=true)
     * @JMSSerializer\Expose
     */
    private $sequence;    
    
    /**
     * @ORM\Column(type="string", name="name")
     * @JMSSerializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", name="question_type")
     * @JMSSerializer\Expose
     */
    private $questionType;     

    /**
     * @ORM\Column(type="text", name="validation", nullable=true)
     * @JMSSerializer\Expose
     */
    private $validation;    

    /**
     * @ORM\Column(type="boolean", name="required", nullable=true)
     * @JMSSerializer\Expose
     */
    private $required;
    
    /**
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="questions")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     * @JMSSerializer\Expose
     * @MaxDepth(2)
     */
    private $form;
    
    /**
     * @ORM\OneToMany(targetEntity="Option", mappedBy="question", cascade={"remove"})
     * @JMSSerializer\Expose
     */
    private $options;    
    
    public function __construct() {
        $this->options = new ArrayCollection();
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
    public function getSequence() {
        return $this->sequence;
    }

    /**
     * @param mixed $sequence
     * @return Question
     */
    public function setSequence($sequence) {
        $this->sequence = $sequence;
        return $this;
    }    
    
    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Question
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuestionType() {
        return $this->questionType;
    }

    /**
     * @param mixed $questionType
     * @return Question
     */
    public function setQuestionType($questionType) {
        $this->questionType = $questionType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidation() {
        return $this->validation;
    }

    /**
     * @param mixed $validation
     * @return Question
     */
    public function setValidation($validation) {
        $this->validation = $validation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequired() {
        return $this->required;
    }

    /**
     * @param mixed $required
     * @return Question
     */
    public function setRequired($required) {
        $this->required = $required;
        return $this;
    }    
    
    /**
     * Add form
     *
     * @param \AppBundle\Entity\Form $form
     * @return Question
     */
    public function addForm(\AppBundle\Entity\Form $form) {
        $this->form = $form;
        return $this;
    }
    
    /**
     * Add options
     *
     * @param \AppBundle\Entity\Option $options
     * @return Question
     */
    public function addOption(\AppBundle\Entity\Option $options) {
        $this->options[] = $options;
        return $this;
    }

    /**
     * Remove options
     *
     * @param \AppBundle\Entity\Option $options
     */
    public function removeOption(\AppBundle\Entity\Option $options) {
        $this->options->removeElement($options);
    }

    /**
     * Get options
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptions() {
        return $this->options;
    }   
    
    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'sequence' => $this->sequence,
            'name' => $this->name,
            'questionType' => $this->questionType,
            'options' => $this->options,
            'validation' => $this->validation,
            'required' => $this->required
        ];
    }

    /**
     * @param \AppBundle\Entity\Option $option
     * @return bool
     */
    public function hasOption(Option $option) {
        return $this->getOptions()->contains($option);
    }

}


