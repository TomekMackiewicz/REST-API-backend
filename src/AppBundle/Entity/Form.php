<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\FormRepository")
 * @ORM\Table(name="forms")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Form implements \JsonSerializable {

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
     * @ORM\Column(type="string", name="description")
     * @JMSSerializer\Expose
     */
    private $description;   
    
    /**
     * @ORM\OneToOne(targetEntity="FormConfig")
     * @ORM\JoinColumn(name="config_id", referencedColumnName="id")
     * @JMSSerializer\Expose
     */
    private $config;    
    
    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="form")
     * @JMSSerializer\Expose
     */
    private $questions;

    public function __construct() {
        $this->questions = new ArrayCollection();
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
     * @return Form
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Form
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Add FormConfig
     *
     * @param \AppBundle\Entity\FormConfig $config
     * @return Form
     */
    public function addConfig(\AppBundle\Entity\FormConfig $config) {
        $this->config = $config;
        return $this;
    }

    /**
     * Get FormConfig
     *
     * @return FormConfig
     */
    public function getConfig() {
        return $this->config;
    }    
    
    /**
     * Add questions
     *
     * @param \AppBundle\Entity\Question $questions
     * @return Form
     */
    public function addQuestion(\AppBundle\Entity\Question $questions) {
        $this->questions[] = $questions;
        return $this;
    }

    /**
     * Remove questions
     *
     * @param \AppBundle\Entity\Question $questions
     */
    public function removeQuestion(\AppBundle\Entity\Question $questions) {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions() {
        return $this->questions;
    }

    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'config' => $this->config,
            'questions' => $this->questions
        ];
    }

    /**
     * @param \AppBundle\Entity\Question $question
     * @return bool
     */
    public function hasQuestion(Question $question) {
        return $this->getQuestions()->contains($question);
    }

}

