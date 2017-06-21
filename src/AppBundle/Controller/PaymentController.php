<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;

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
        
        $data = $request->getContent();       
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://secure.snd.payu.com/api/v2_1/orders");
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer d9a4536e-62ba-4f60-8017-6053211d3f47'
        ));
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //$test = curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        //$server_output = json_decode(curl_exec ($curl), true);
        //$server_output = curl_exec ($curl);
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_exec ($curl);
        $response = curl_getinfo( $curl );
        curl_close ($curl);

        $cu = curl_init($response["redirect_url"]);
        curl_setopt($cu, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($cu);
        curl_close ($cu);
        //ob_start();
        //print_r($response["redirect_url"]);
        //$textualRepresentation = ob_get_contents();
        //ob_end_clean();
        //file_put_contents('/home/tomek/Workspace/log.log', $textualRepresentation); 
//        if ($server_output["status"]["statusCode"] == "SUCCESS") {
//            return $this->redirect($server_output["redirectUri"]);
//        } else { 
//            //return $this->redirect('');    
//        }

    }    
    
}
