<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ReadyTextRepository")
 * @ORM\Table(name="texts")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class ReadyText implements \JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;    

    /**
     * @ORM\Column(type="string", name="token")
     * @JMSSerializer\Expose
     */
    private $token;
    
    /**
     * @ORM\Column(type="string", name="title")
     * @JMSSerializer\Expose
     */
    private $title;

    /**
     * @ORM\Column(type="text", name="body")
     * @JMSSerializer\Expose
     */
    private $body;

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

    public function __construct() {
        $this->addDate = new \DateTime();
        //$this->token = base64_encode(random_bytes(10)); random_int(100, 999)
        $this->token = random_int(100000000, 999999999);
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
    public function getToken() {
        return $this->token;
    }
    
    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Document
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Document
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'addDate' => $this->addDate,
            'token' => $this->token
        ];
    }

}

