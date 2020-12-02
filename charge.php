<?php
require_once "config.php";
session_start();
  
if (isset($_POST['stripeToken']) && !empty($_POST['stripeToken'])) {
 
    try {
        $token = $_POST['stripeToken'];
     
        $response = $gateway->purchase([
            'amount' => $_POST['amount'],
            'currency' => 'PHP',
            'token' => $token,
        ])->send();
     
        if ($response->isSuccessful()) {
            // payment was successful: update database
            $arr_payment_data = $response->getData();
            $payment_id = $arr_payment_data['id'];
            $amount = $_POST['amount'];
 
            // Insert transaction data into the database
            $isPaymentExist = $db->query("SELECT * FROM payments WHERE payment_id = '".$payment_id."'")->fetch();

            if(!$isPaymentExist) { 
                $sql = "INSERT INTO payments(payment_id, amount, currency, payment_status,userid) VALUES(?,?,?,?,?)
                ";

                $db->prepare($sql)->execute(array($payment_id, $amount, 'PHP', 'Captured', $_SESSION['id']));
            } 
            
            header("Location:success.php");
        } else {
            // payment failed: display message to customer
            echo ' <div class="alert alert-danger" role="alert">'.$response->getMessage().'</div>';
        }
    } catch(Exception $e) {
            echo ' <div class="alert alert-danger" role="alert">'.$response->getMessage().'</div>';
    }
}