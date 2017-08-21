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
    
//    /**
//     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
//     * @JMSSerializer\Expose
//     */
//    private $answers;    
    
    public function __construct() {
        $this->options = new ArrayCollection();
        //$this->answers = new ArrayCollection();
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

//    /**
//     * Remove form
//     *
//     * @param \AppBundle\Entity\Form $form
//     */
//    public function removeForm(\AppBundle\Entity\Form $form) {
//        $this->form->removeElement($form);
//    }
    
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

//    /**
//     * Add answers
//     *
//     * @param \AppBundle\Entity\Answer $answers
//     * @return Question
//     */
//    public function addAnswer(\AppBundle\Entity\Answer $answers) {
//        $this->answers[] = $answers;
//        return $this;
//    }
//
//    /**
//     * Remove answers
//     *
//     * @param \AppBundle\Entity\Answer $answers
//     */
//    public function removeAnswer(\AppBundle\Entity\Answer $answers) {
//        $this->answers->removeElement($answers);
//    }
//
//    /**
//     * Get answers
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getAnswers() {
//        return $this->answers;
//    }    
    
    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
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


