<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AnswerRepository")
 * @ORM\Table(name="answers")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Answer implements \JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="body")
     * @JMSSerializer\Expose
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * @JMSSerializer\Expose
     * @MaxDepth(1)
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
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Answer
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     * @return Answer
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
            'body' => $this->body
        ];
    }

}
