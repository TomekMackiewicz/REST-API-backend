<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Payment;
use AppBundle\Form\Type\PaymentType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use Symfony\Component\HttpFoundation\Response;
//use Unirest;
use OpenPayU_Configuration;
use OpenPayU_Order;

/**
 * Class PaymentController
 * @package AppBundle\Controller
 *
 * @RouteResource("payment")
 */
class PaymentController extends FOSRestController implements ClassResourceInterface {

    /**
     * Gets an individual payment
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Payment",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function getAction(int $id) {
        $payment = $this->getPaymentRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($payment === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $payment;
    }

    /**
     * Gets a collection of payments
     *
     * @return array
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Payment",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction() {
        return $this->getPaymentRepository()->createFindAllQuery()->getResult();
    }

    /**
     *
     * Adds a payment
     *
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\PaymentType",
     *     output="AppBundle\Entity\Payment",
     *     statusCodes={
     *         201 = "Returned when a new Form has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postAction(Request $request) {        
        $data = $request->request->all();        
        $json = json_decode($request->getContent(), TRUE);
        $token = $this->getToken($data['id']);
        $em = $this->getDoctrine()->getManager();
        
        $payment = new Payment();
        $payment->setTotalAmount($data['totalAmount']/100);
        $payment->setUnitPrice($data['products'][0]['unitPrice']/100);
        $payment->setQuantity($data['products'][0]['quantity']);
        $payment->setName($data['products'][0]['name']);
        $payment->setEmail($data['buyer']['email']);
        $payment->setPhone($data['buyer']['phone']);
        $payment->setFirstName($data['buyer']['firstName']); 
        $payment->setLastName($data['buyer']['lastName']);
        $payment->setToken($token['token']);
                            
        $em->persist($payment);
        $em->flush();       
               
        return $this->processPayment($json, $token['token']);
    }

    /**
     *
     * Process payment
     *
     * @param Request $request
     *
     */
    private function processPayment($data, $token) {
        // przenieść do configu
        OpenPayU_Configuration::setEnvironment('sandbox');
        OpenPayU_Configuration::setMerchantPosId('302325');
        OpenPayU_Configuration::setSignatureKey('f289568f7d7937e9168519f17217f07d');
        OpenPayU_Configuration::setOauthClientId('302325');
        OpenPayU_Configuration::setOauthClientSecret('826745237794f7fd98a0f4e6ca5a38e2');
        
        $order['continueUrl'] = 'http://localhost:4200/texts/full/' . $token;
        $order['notifyUrl'] = 'http://localhost:4200/notify';
        $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $order['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
        $order['description'] = 'New order';
        $order['currencyCode'] = 'PLN';
        $order['totalAmount'] = $data['totalAmount'];
        $order['settings']['invoiceDisabled'] = $data['settings']['invoiceDisabled'];
        //$order['extOrderId'] = '1342'; //must be unique!
        $order['products'][0]['name'] = $data['products'][0]['name'];
        $order['products'][0]['unitPrice'] = $data['products'][0]['unitPrice'];
        $order['products'][0]['quantity'] = $data['products'][0]['quantity'];
        $order['buyer']['email'] = $data['buyer']['email'];
        $order['buyer']['phone'] = $data['buyer']['phone'];
        $order['buyer']['firstName'] = $data['buyer']['firstName'];
        $order['buyer']['lastName'] = $data['buyer']['lastName'];        
        $order['buyer']['language'] = $data['buyer']['language'];
        
        $response = OpenPayU_Order::create($order);

        return $response->getResponse()->redirectUri;        
    }

    private function getToken($id) {
        $token = $this->getReadyTextRepository()->createFindTokenQuery($id)->getSingleResult();
        if ($token === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $token;        
    }    

    /**
     * @return PaymentRepository
     */
    private function getPaymentRepository() {
        return $this->get('crv.doctrine_entity_repository.payment');
    }
    
    /**
     * @return ReadyTextRepository
     */
    private function getReadyTextRepository() {
        return $this->get('crv.doctrine_entity_repository.readyText');
    }
    
}
