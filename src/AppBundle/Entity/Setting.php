<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SettingRepository")
 * @ORM\Table(name="settings")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Setting implements \JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="float", name="price", nullable=true)
     * @JMSSerializer\Expose
     */
    private $price;       

    /**
     * @ORM\Column(type="string", name="transition", nullable=true)
     * @JMSSerializer\Expose
     */
    private $transition;
    
    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return Setting
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }       

    /**
     * @return mixed
     */
    public function getTransition() {
        return $this->transition;
    }

    /**
     * @param mixed $transition
     * @return Setting
     */
    public function setTransition($transition) {
        $this->transition = $transition;
        return $this;
    } 
    
    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'transition' => $this->transition
        ];
    }

}
