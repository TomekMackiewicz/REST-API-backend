<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Unirest;

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
        $form = json_decode($request->getContent(), TRUE);
        $secondKey = 'f289568f7d7937e9168519f17217f07d';
        $algorithm = 'SHA-256';
        $posId = "302325";        
                
        $auth = Unirest\Request::post(
            'https://secure.snd.payu.com/pl/standard/user/oauth/authorize', 
            $headers = array(), 
            $body = 'grant_type=client_credentials&client_id=302325&client_secret=826745237794f7fd98a0f4e6ca5a38e2'   
        );              
        $arr2 = [
            //"notifyUrl" => "https://google.com",
            "notifyUrl" => "http://shop.url/notify",
            "customerIp" => "127.0.0.1",
            //"customerIp" => "123.123.123.123",
            //"continueUrl" => "https://google.com",
            "continueUrl" => "http://shop.url/continue",
            "merchantPosId" => $posId,
            //"merchantPosId" => 145227,
            "description" => "RTVmarket",
            "currencyCode" => "PLN",
            "totalAmount" => "10000",
            //"extOrderId" => "xakcvih7tjamkw2ga106ul",
            //"OpenPayu-Signature" => "sender=145227;algorithm=SHA-256;signature=bc94a8026d6032b5e216be112a5fb7544e66e23e68d44b4283ff495bdb3983a8"
            //"OpenPayu-Signature" => $signature
        ];
        $arr3 = array_merge($arr2, $form);  

        $signature = $this->generateSignData($arr3, $algorithm, $posId, $secondKey);
        
        $arr4 = [
            "OpenPayu-Signature" => $signature
        ];
        
        $arr5 = array_merge($arr3, $arr4);
        
        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' .$auth->body->access_token
        );

        $body = Unirest\Request\Body::json($arr5);
        
        $response = Unirest\Request::post('https://secure.snd.payu.com/api/v2_1/orders', $headers, $body);
        //$response = Unirest\Request::post('https://secure.payu.com/api/v2_1/orders', $headers, $body);
//        ob_start();
//        print_r($body);
//        $textualRepresentation = ob_get_contents();
//        ob_end_clean();
//        file_put_contents('/var/www/log.log', $textualRepresentation);              

        return $response;
    }

    /**
     * Function generate sign data
     *
     * @param array $data
     * @param string $algorithm
     * @param string $merchantPosId
     * @param string $signatureKey
     *
     * @return string
     *
     * @throws OpenPayU_Exception_Configuration
     */
    public static function generateSignData(array $data, $algorithm = 'SHA-256', $merchantPosId = '', $signatureKey = '')
    {
        if (empty($signatureKey))
            throw new OpenPayU_Exception_Configuration('Merchant Signature Key should not be null or empty.');
        if (empty($merchantPosId))
            throw new OpenPayU_Exception_Configuration('MerchantPosId should not be null or empty.');
        $contentForSign = '';

        //$aamount = ['totalAmount' => $form['totalAmount']];
        //$abuyer = $form['buyer'];
        //$aproducts = $form['products'];
        //$flatten = array_merge($aamount, $abuyer, $aproducts);
$test = self::flatten($data);
        
        ksort($test);       

        ob_start();
        print_r($test);
        $textualRepresentation = ob_get_contents();
        ob_end_clean();
        file_put_contents('/var/www/log.log', $textualRepresentation);  
        
//        foreach ($data as $key => $value) {
//            $contentForSign .= $key . '=' . urlencode($value) . '&';                
//        }
        
$contentForSign = 'buyer[email]=tomek@gmail.com&'
        . 'buyer[firstName]=tomek&'
        . 'buyer[lastName]=Mackiewicz&'
        . 'buyer[phone]=111111111&'
        . 'continueUrl=http://shop.url/continue&'
        . 'currencyCode=PLN&'
        . 'customerIp=127.0.0.1&'
        . 'description=RTVmarket&'        
        . 'merchantPosId=302325&'        
        . 'notifyUrl=http://shop.url/notify&'        
        . 'products[0][name]=legalForm&'        
        . 'products[0][unitPrice]=10000&'
        . 'products[0][quantity]=1&'        
        . 'totalAmount=10000'
        ;

        
        if (in_array($algorithm, array('SHA-256', 'SHA'))) {
            $hashAlgorithm = 'sha256';
            $algorithm = 'SHA-256';
        } else if ($algorithm == 'SHA-384') {
            $hashAlgorithm = 'sha384';
            $algorithm = 'SHA-384';
        } else if ($algorithm == 'SHA-512') {
            $hashAlgorithm = 'sha512';
            $algorithm = 'SHA-512';
        }
        $signature = hash($hashAlgorithm, $contentForSign . $signatureKey);
        $signData = 'sender=' . $merchantPosId . ';algorithm=' . $algorithm . ';signature=' . $signature;
       
        return $signData;
    }

private function flatten($array, $prefix = '') {
    $result = array();
    foreach($array as $key=>$value) {
        if(is_array($value)) {
            $result = $result + flatten($value, $prefix . $key . '.');
        }
        else {
            $result[$prefix . $key] = $value;
        }
    }
    return $result;
}
    
}
