<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use JMS\Serializer\Annotation as JMSSerializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Order implements \JsonSerializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    private $id;

    /** 
     * @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction") 
     * @JMSSerializer\Expose
     */
    private $paymentInstruction;

    /** 
     * @ORM\Column(type="decimal", precision=10, scale=5)
     * @JMSSerializer\Expose 
     */
    private $amount;

//    public function __construct($amount)
//    {
//        $this->amount = $amount;
//    }

    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return Order
     */
    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }    
    
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }

    public function setPaymentInstruction(PaymentInstruction $instruction)
    {
        $this->paymentInstruction = $instruction;
    }

    /**
     * @return mixed
     */
    function jsonSerialize() 
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'paymentInstruction' => $this->paymentInstruction
        ];
    }
    
}
