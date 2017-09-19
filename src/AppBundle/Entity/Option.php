<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\OptionRepository")
 * @ORM\Table(name="options")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Option implements \JsonSerializable {

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
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="options")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * @JMSSerializer\Expose
     */
    private $question;    
    
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
    public function getIsAnswer() {
        return $this->isAnswer;
    }

    /**
     * @param mixed $isAnswer
     * @return Option
     */
    public function setIsAnswer($isAnswer) {
        $this->isAnswer = $isAnswer;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getSelected() {
        return $this->selected;
    }

    /**
     * @param mixed $selected
     * @return Option
     */
    public function setSelected($selected) {
        $this->selected = $selected;
        return $this;
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     * @return Option
     */
    public function addQuestion(\AppBundle\Entity\Question $question) {
        $this->question = $question;
        return $this;
    }    
    
    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'questionId' => $this->questionId,
            'isAnswer' => $this->isAnswer,
            'selected' => $this->selected
        ];
    }

}



