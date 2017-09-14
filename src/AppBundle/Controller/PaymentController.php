<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
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
        
        // przenieść do configu
        OpenPayU_Configuration::setEnvironment('sandbox');
        OpenPayU_Configuration::setMerchantPosId('302325');
        OpenPayU_Configuration::setSignatureKey('f289568f7d7937e9168519f17217f07d');
        OpenPayU_Configuration::setOauthClientId('302325');
        OpenPayU_Configuration::setOauthClientSecret('826745237794f7fd98a0f4e6ca5a38e2');        
        
        $data = json_decode($request->getContent(), TRUE);       
        //$this->processPayment($data);
        // get text token by id $data['id']
        
        $order['continueUrl'] = 'http://localhost:4200/text/full/' . $data['id']; // text full + token
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
        // save order data (usunąć email z text, niepotrzebny)
        
        $response = OpenPayU_Order::create($order);

        return $response->getResponse()->redirectUri;
    }

    /**
     *
     * Process payment
     *
     * @param Request $request
     *
     */
    private function processPayment($data) {
        
    }
    
}
