<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\FormConfigRepository")
 * @ORM\Table(name="form_config")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class FormConfig implements \JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;  
    
    /**
     * @ORM\Column(type="boolean", name="allow_back", nullable=true)
     * @JMSSerializer\Expose
     */
    private $allowBack;         
    
    /**
     * @ORM\Column(type="boolean", name="auto_move", nullable=true)
     * @JMSSerializer\Expose
     */
    private $autoMove;        
    
    /**
     * @ORM\Column(type="boolean", name="required_all", nullable=true)
     * @JMSSerializer\Expose
     */
    private $requiredAll;         
    
    /**
     * @ORM\Column(type="boolean", name="shuffle_questions", nullable=true)
     * @JMSSerializer\Expose
     */
    private $shuffleQuestions;     
    
    /**
     * @ORM\Column(type="boolean", name="shuffle_options", nullable=true)
     * @JMSSerializer\Expose
     */
    private $shuffleOptions;        
    
    /**
     * @ORM\Column(type="boolean", name="show_pager", nullable=true)
     * @JMSSerializer\Expose
     */
    private $showPager;       

//    /**
//     * @ORM\OneToOne(targetEntity="Form")
//     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
//     * @JMSSerializer\Expose
//     */
//    private $form;   
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAllowBack() {
        return $this->allowBack;
    }

    /**
     * @param mixed $allowBack
     * @return FormConfig
     */
    public function setAllowBack($allowBack) {
        $this->allowBack = $allowBack;
        return $this;
    }   

    /**
     * @return mixed
     */
    public function getAutoMove() {
        return $this->autoMove;
    }

    /**
     * @param mixed $autoMove
     * @return FormConfig
     */
    public function setAutoMove($autoMove) {
        $this->autoMove = $autoMove;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequiredAll() {
        return $this->requiredAll;
    }

    /**
     * @param mixed $requiredAll
     * @return FormConfig
     */
    public function setRequiredAll($requiredAll) {
        $this->requiredAll = $requiredAll;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShuffleQuestions() {
        return $this->shuffleQuestions;
    }

    /**
     * @param mixed $shuffleQuestions
     * @return FormConfig
     */
    public function setShuffleQuestions($shuffleQuestions) {
        $this->shuffleQuestions = $shuffleQuestions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShuffleOptions() {
        return $this->shuffleOptions;
    }

    /**
     * @param mixed $shuffleOptions
     * @return FormConfig
     */
    public function setShuffleOptions($shuffleOptions) {
        $this->shuffleOptions = $shuffleOptions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShowPager() {
        return $this->showPager;
    }

    /**
     * @param mixed $showPager
     * @return FormConfig
     */
    public function setShowPager($showPager) {
        $this->showPager = $showPager;
        return $this;
    }

//    /**
//     * Add Form
//     *
//     * @param \AppBundle\Entity\Form $form
//     * @return FormConfig
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
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'allowBack' => $this->allowBack,
            'autoMove' => $this->autoMove,
            'requiredAll' => $this->requiredAll,
            'shuffleQuestions' => $this->shuffleQuestions,
            'shuffleOptions' => $this->shuffleOptions,
            'showPager' => $this->showPager,
        ];
    }

}




