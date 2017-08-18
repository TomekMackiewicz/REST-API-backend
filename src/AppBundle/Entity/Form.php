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
     * @ORM\Column(type="text", name="description")
     * @JMSSerializer\Expose
     */
    private $description;   

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
    
    /**
     * @ORM\OneToOne(targetEntity="FormConfig", cascade={"remove"})
     * @ORM\JoinColumn(name="config_id", referencedColumnName="id")
     * @JMSSerializer\Expose
     */
    private $config;    
    
    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="form", cascade={"remove"})
     * @JMSSerializer\Expose
     */
    private $questions;
    
    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="forms")
     * @ORM\JoinTable(
     *  name="form_category",
     *  joinColumns={
     *      @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *  }
     * )
     * @JMSSerializer\Expose
     * @MaxDepth(2)
     */
    private $categories;    

    public function __construct() {
        $this->addDate = new \DateTime();
        $this->questions = new ArrayCollection();
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
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Form
     */
    public function setModifiedDate($modifiedDate) {
        $this->modifiedDate = $modifiedDate;
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
     * Remove question
     *
     * @param \AppBundle\Entity\Question $question
     */
    public function removeQuestion(\AppBundle\Entity\Question $question) {
        //$this->questions->removeElement($question);
        //$question->setForm(null);
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
     * Add categories
     *
     * @param \AppBundle\Entity\Category $categories
     * @return Form
     */
    public function addCategory(\AppBundle\Entity\Category $categories) {
        $this->categories[] = $categories;
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \AppBundle\Entity\Category $categories
     */
    public function removeCategory(\AppBundle\Entity\Category $categories) {
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
            'name' => $this->name,
            'description' => $this->description,
            'config' => $this->config,
            'questions' => $this->questions,
            'categories' => $this->categories
        ];
    }

    /**
     * @param \AppBundle\Entity\Question $question
     * @return bool
     */
    public function hasQuestion(Question $question) {
        return $this->getQuestions()->contains($question);
    }

    /**
     * @param \AppBundle\Entity\Category $category
     * @return bool
     */
    public function hasCategory(Category $category) {
        return $this->getCategories()->contains($category);
    }    
    
}

