<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMSSerializer;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PaymentRepository")
 * @ORM\Table(name="payments")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Payment implements \JsonSerializable {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="total_amount")
     * @JMSSerializer\Expose
     */
    private $totalAmount;

    /**
     * @ORM\Column(type="integer", name="unit_price")
     * @JMSSerializer\Expose
     */
    private $unitPrice;    

    /**
     * @ORM\Column(type="integer", name="quantity")
     * @JMSSerializer\Expose
     */
    private $quantity; 
    
    /**
     * @ORM\Column(type="string", name="name")
     * @JMSSerializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", name="email")
     * @JMSSerializer\Expose
     */
    private $email;    

    /**
     * @ORM\Column(type="string", name="phone")
     * @JMSSerializer\Expose
     */
    private $phone;

    /**
     * @ORM\Column(type="string", name="firstName")
     * @JMSSerializer\Expose
     */
    private $firstName;    

    /**
     * @ORM\Column(type="string", name="lastName")
     * @JMSSerializer\Expose
     */
    private $lastName;     

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     * @Assert\Date()(
     *  message = "Invalid value (expected: date format)."
     * )
     * @JMSSerializer\Expose
     */
    private $date;

    public function __construct() {
        $this->date = new \DateTime();
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
    public function getTotalAmount() {
        return $this->totalAmount;
    }

    /**
     * @param mixed $totalAmount
     * @return Payment
     */
    public function setTotalAmount($totalAmount) {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnitPrice() {
        return $this->unitPrice;
    }

    /**
     * @param mixed $unitPrice
     * @return Payment
     */
    public function setUnitPrice($unitPrice) {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return Payment
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Payment
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Payment
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Payment
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return Payment
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return Payment
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    function jsonSerialize() {
        return [
            'id' => $this->id,
            'totalAmount' => $this->totalAmount,
            'unitPrice' => $this->unitPrice,
            'quantity' => $this->quantity,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,            
            'firstName' => $this->firstName,            
            'lastName' => $this->lastName,            
            'date' => $this->date,            
        ];
    }
    
}
