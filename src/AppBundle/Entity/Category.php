<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Category implements \JsonSerializable {

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
     * @ORM\ManyToMany(targetEntity="Form", mappedBy="categories")
     * @JMSSerializer\Expose
     * @MaxDepth(2)
     */
    private $forms;    
    
    public function __construct() {
        $this->forms = new ArrayCollection();
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
     * @return Category
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Add form
     *
     * @param \AppBundle\Entity\Form $form
     * @return Category
     */
    public function addForm(\AppBundle\Entity\Form $form) {
        $this->forms[] = $form;
        return $this;
    }

    /**
     * Remove form
     *
     * @param \AppBundle\Entity\Form $form
     */
    public function removeForm(\AppBundle\Entity\Form $form) {
        $this->forms->removeElement($form);
    }

    /**
     * Get forms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getForms() {
        return $this->forms;
    }    
    
    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            //'documents' => $this->documents,
            'forms' => $this->forms
        ];
    }

    /**
     * @param \AppBundle\Entity\Form $form
     * @return bool
     */
    public function hasForm(Form $form) {
        return $this->getForms()->contains($form);
    }    
    
}
