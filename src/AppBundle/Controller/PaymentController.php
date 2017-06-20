<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Payment;

class PaymentController {

    /**
     * @param Request $request
     */
    public function verifyTransaction(Request $request) {
        //session_start();
        //Fragment kodu odpowiedzialny za weryfikacje transakcji.
        if ($_GET["ok"] == 2) {
            $P24 = new Przelewy24(
                    $_POST["p24_merchant_id"], $_POST["p24_pos_id"], $_POST['p24_crc'], $_POST['env']);

            foreach ($_POST as $k => $v) {
                $P24->addValue($k, $v);
            }

            $P24->addValue('p24_currency', $_POST['p24_currency']);
            $P24->addValue('p24_amount', $_POST['p24_amount']);
            $res = $P24->trnVerify();
            if (isset($res["error"]) and $res["error"] === '0') {
                $msg = 'Transakcja została zweryfikowana poprawnie';
            } else {
                $msg = 'Błędna weryfikacja transakcji';
            }

            exit;
        }

        if (isset($_POST["submit_test"])) {
            echo '<h2>Wynik:</h2>';
            $test = ($_POST["env"] == 1 ? true : false);
            $salt = $_POST["salt"];
            $P24 = new Przelewy24($_POST["p24_merchant_id"], $_POST["p24_pos_id"], $salt, $test
            );
            $RET = $P24->testConnection();
            echo '<pre>RESPONSE:' . print_r($RET, true) . '</pre>';
        } elseif (isset($_POST["submit_send"])) {
            echo '<h2>Wynik:</h2>';
            $test = ($_POST["env"] == 1 ? "1" : "0");
            $salt = $_POST["salt"];

            $P24 = new Przelewy24($_POST["p24_merchant_id"], $_POST["p24_pos_id"], $salt, $test);

            foreach ($_POST as $k => $v) {
                $P24->addValue($k, $v);
            }
            //file_put_contents("parametry.txt", "p24_crc=" . $_POST['salt'] . "&p24_amount=" . $_POST['p24_amount'] . "&p24_currency=" . $_POST['p24_currency'] . "&env=" . $test);


            $bool = ($_POST["redirect"] == "on") ? true : false;
            $res = $P24->trnRegister($bool);

            echo '<pre>RESPONSE:' . print_r($res, true) . '</pre>';

            if (isset($res["error"]) and $res["error"] === '0') {
                echo '<br/><a href="' . $P24->getHost() . "trnRequest/" . $res["token"] . '">' . $P24->getHost() . "trnRequest/" . $res["token"] . '</a>';
            }
        }

        $protocol = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ) ? "https://" : "http://";
//session_regenerate_id();
    }

}
