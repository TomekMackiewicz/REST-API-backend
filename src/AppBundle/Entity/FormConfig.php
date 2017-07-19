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
     * @ORM\Column(type="boolean", name="allow_review", nullable=true)
     * @JMSSerializer\Expose
     */
    private $allowReview;     
    
    /**
     * @ORM\Column(type="boolean", name="auto_move", nullable=true)
     * @JMSSerializer\Expose
     */
    private $autoMove;    
    
    /**
     * @ORM\Column(type="integer", name="duration", nullable=true)
     * @JMSSerializer\Expose
     */
    private $duration;     
    
    /**
     * @ORM\Column(type="integer", name="page_size", nullable=true)
     * @JMSSerializer\Expose
     */
    private $pageSize;     
    
    /**
     * @ORM\Column(type="boolean", name="required_all", nullable=true)
     * @JMSSerializer\Expose
     */
    private $requiredAll;     
    
    /**
     * @ORM\Column(type="boolean", name="rich_text", nullable=true)
     * @JMSSerializer\Expose
     */
    private $richText;     
    
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
     * @ORM\Column(type="boolean", name="show_clock", nullable=true)
     * @JMSSerializer\Expose
     */
    private $showClock;     
    
    /**
     * @ORM\Column(type="boolean", name="show_pager", nullable=true)
     * @JMSSerializer\Expose
     */
    private $showPager;    
    
    /**
     * @ORM\Column(type="string", name="theme", nullable=true)
     * @JMSSerializer\Expose
     */
    private $theme;    

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
    public function getAllowReview() {
        return $this->allowReview;
    }

    /**
     * @param mixed $allowReview
     * @return FormConfig
     */
    public function setAllowReview($allowReview) {
        $this->allowReview = $allowReview;
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
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     * @return FormConfig
     */
    public function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPageSize() {
        return $this->pageSize;
    }

    /**
     * @param mixed $pageSize
     * @return FormConfig
     */
    public function setPageSize($pageSize) {
        $this->pageSize = $pageSize;
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
    public function getRichText() {
        return $this->richText;
    }

    /**
     * @param mixed $richText
     * @return FormConfig
     */
    public function setRichText($richText) {
        $this->richText = $richText;
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
    public function getShowClock() {
        return $this->showClock;
    }

    /**
     * @param mixed $showClock
     * @return FormConfig
     */
    public function setShowClock($showClock) {
        $this->showClock = $showClock;
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

    /**
     * @return mixed
     */
    public function getTheme() {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     * @return FormConfig
     */
    public function setTheme($theme) {
        $this->theme = $theme;
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
            'allowReview' => $this->allowReview,
            'autoMove' => $this->autoMove,
            'duration' => $this->duration,
            'pageSize' => $this->pageSize,
            'requiredAll' => $this->requiredAll,
            'richText' => $this->richText,
            'shuffleQuestions' => $this->shuffleQuestions,
            'shuffleOptions' => $this->shuffleOptions,
            'showClock' => $this->showClock,
            'showPager' => $this->showPager,
            'theme' => $this->theme,
            'form' => $this->form
        ];
    }

}




