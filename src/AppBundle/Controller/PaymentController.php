<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
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
     *
     * Process payment
     *
     * @param Request $request
     *
     */
    public function postAction(Request $request) { 

        OpenPayU_Configuration::setEnvironment('sandbox');
        OpenPayU_Configuration::setMerchantPosId('302325');
        OpenPayU_Configuration::setSignatureKey('f289568f7d7937e9168519f17217f07d');
        OpenPayU_Configuration::setOauthClientId('302325');
        OpenPayU_Configuration::setOauthClientSecret('826745237794f7fd98a0f4e6ca5a38e2');        
        
        $data = json_decode($request->getContent(), TRUE);       
        
        $order['continueUrl'] = 'http://localhost:4200';
        $order['notifyUrl'] = 'http://localhost:4200';
        $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $order['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
        $order['description'] = 'New order';
        $order['currencyCode'] = 'PLN';
        $order['totalAmount'] = 10000;
        //$order['extOrderId'] = '1342'; //must be unique!

        $order['products'][0]['name'] = $data['products'][0]['name'];
        $order['products'][0]['unitPrice'] = $data['products'][0]['unitPrice'];
        $order['products'][0]['quantity'] = $data['products'][0]['quantity'];

        $order['buyer']['email'] = $data['buyer']['email'];
        $order['buyer']['phone'] = $data['buyer']['phone'];
        $order['buyer']['firstName'] = $data['buyer']['firstName'];
        $order['buyer']['lastName'] = $data['buyer']['lastName'];        
        
        $response = OpenPayU_Order::create($order);

        return $response->getResponse()->redirectUri;
    }
    
}
