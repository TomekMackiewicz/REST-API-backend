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

        $auth = Unirest\Request::post(
            'https://secure.snd.payu.com/pl/standard/user/oauth/authorize', 
            $headers = array(), 
            $body = 'grant_type=client_credentials&client_id=302325&client_secret=826745237794f7fd98a0f4e6ca5a38e2'
        );
               
        $arr1 = json_decode($request->getContent(), TRUE);
        $arr2 = [
            "notifyUrl" => "http://tomek.pl",
            "customerIp" => "127.0.0.1",
            "merchantPosId" => "302325",
            "description" => "RTV market",
            "currencyCode" => "PLN",
            //"OpenPayu-Signature" => "sender=302325;algorithm=SHA-256;signature=f289568f7d7937e9168519f17217f07d"
        ];
        $arr3 = array_merge($arr1, $arr2);
        $json = json_encode($arr3);        
        
        $response = Unirest\Request::post(
            'https://secure.snd.payu.com/api/v2_1/orders', 
            $headers = array(
                'Accept' => 'application/json',
                'Authorization: Bearer '.$auth->body->access_token
            ), 
            $body = $json
        );
        
        ob_start();
        print_r($response);
        $textualRepresentation = ob_get_contents();
        ob_end_clean();
        file_put_contents('/var/www/log.log', $textualRepresentation);

        $secondKey = 'f289568f7d7937e9168519f17217f07d';
        $algorithm = 'SHA-256';
        $posId = 302325;
        $test = $this->generateSignature($request->getContent(), $secondKey, $algorithm, $posId);
        
        return $response;
    }
  
    private function generateSignature($form, $secondKey, $algorithm, $posId) {
        $sortedValues = sortValuesByItsName($form);

        foreach value in sortedValues {
            $content = $content + $parameterName + "=" + urlencode($value) + "&"
        }

        $content = $content + $secondKey;

        $result = "signature=" + $algorithm.apply(content) + ";";
        $result = $result + "algorithm=" + $algorithm.name + ";";
        $result = $result + "sender=" + $posId;

        return $result;
    }
    
}
