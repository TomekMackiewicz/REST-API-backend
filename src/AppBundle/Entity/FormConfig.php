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
     * @ORM\Column(type="boolean", name="show_pager", nullable=true)
     * @JMSSerializer\Expose
     */
    private $showPager;  
    
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
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'allowBack' => $this->allowBack,
            'showPager' => $this->showPager
        ];
    }

}




