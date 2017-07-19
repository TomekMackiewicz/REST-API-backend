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
     * @ORM\Column(type="integer", name="question_type_id")
     * @JMSSerializer\Expose
     */
    private $questionTypeId;     

    /**
     * @ORM\Column(type="integer", name="answered")
     * @JMSSerializer\Expose
     */
    private $answered;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Form", inversedBy="questions")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     * @JMSSerializer\Expose
     */
    private $form;
    
    /**
     * @ORM\OneToMany(targetEntity="Option", mappedBy="question")
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
    public function getQuestionTypeId() {
        return $this->questionTypeId;
    }

    /**
     * @param mixed $questionTypeId
     * @return Question
     */
    public function setQuestionTypeId($questionTypeId) {
        $this->questionTypeId = $questionTypeId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswered() {
        return $this->answered;
    }

    /**
     * @param mixed $answered
     * @return Question
     */
    public function setAnswered($answered) {
        $this->answered = $answered;
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
            'name' => $this->name,
            'questionTypeId' => $this->questionTypeId,
            'options' => $this->options,
            'answered' => $this->answered
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


