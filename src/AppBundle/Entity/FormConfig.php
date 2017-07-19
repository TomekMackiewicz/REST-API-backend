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
     * @ORM\Column(type="integer", name="allow_back")
     * @JMSSerializer\Expose
     */
    private $allowBack;     

    /**
     * @ORM\Column(type="integer", name="allow_review")
     * @JMSSerializer\Expose
     */
    private $allowReview;     
    
    /**
     * @ORM\Column(type="integer", name="auto_move")
     * @JMSSerializer\Expose
     */
    private $autoMove;    
    
    /**
     * @ORM\Column(type="integer", name="duration")
     * @JMSSerializer\Expose
     */
    private $duration;     
    
    /**
     * @ORM\Column(type="integer", name="page_size")
     * @JMSSerializer\Expose
     */
    private $pageSize;     
    
    /**
     * @ORM\Column(type="integer", name="required_all")
     * @JMSSerializer\Expose
     */
    private $requiredAll;     
    
    /**
     * @ORM\Column(type="integer", name="rich_text")
     * @JMSSerializer\Expose
     */
    private $richText;     
    
    /**
     * @ORM\Column(type="integer", name="shuffle_questions")
     * @JMSSerializer\Expose
     */
    private $shuffleQuestions;     
    
    /**
     * @ORM\Column(type="integer", name="shuffle_options")
     * @JMSSerializer\Expose
     */
    private $shuffleOptions;     
    
    /**
     * @ORM\Column(type="integer", name="show_clock")
     * @JMSSerializer\Expose
     */
    private $showClock;     
    
    /**
     * @ORM\Column(type="integer", name="show_pager")
     * @JMSSerializer\Expose
     */
    private $showPager;    
    
    /**
     * @ORM\Column(type="string", name="theme")
     * @JMSSerializer\Expose
     */
    private $theme;    

    /**
     * @ORM\OneToOne(targetEntity="Form")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     * @JMSSerializer\Expose
     */
    private $form;
    
/////////////////////////////////////////////////////////////    
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }
//
//    /**
//     * @return mixed
//     */
//    public function getQuestionId() {
//        return $this->questionId;
//    }
//
//    /**
//     * @param mixed $questionId
//     * @return Option
//     */
//    public function setQuestionId($questionId) {
//        $this->questionId = $questionId;
//        return $this;
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




