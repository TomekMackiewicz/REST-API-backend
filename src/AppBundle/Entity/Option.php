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
     * @ORM\Column(type="integer", name="question_id")
     * @JMSSerializer\Expose
     */
    private $questionId;     

    /**
     * @ORM\Column(type="integer", name="is_answer")
     * @JMSSerializer\Expose
     */
    private $isAnswer;    
    
    /**
     * @ORM\Column(type="integer", name="selected")
     * @JMSSerializer\Expose
     */
    private $selected; 

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
    public function getQuestionId() {
        return $this->questionId;
    }

    /**
     * @param mixed $questionId
     * @return Option
     */
    public function setQuestionId($questionId) {
        $this->questionId = $questionId;
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



