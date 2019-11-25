<?php
    session_start();
    $username = $_SESSION['username'];
    $fullname = $_SESSION['buyer_name'];
    require("../../instamojo/instamojo.php");
    $amount = $_GET['amount'];
    $plans = $_GET['plans'];
    $storage = $_GET['storage'];
    echo $amount;
    $api = new Instamojo\Instamojo('test_794832609d262b743a03b16d165', 'test_7f8c4cf70b87ce749ff182c8c2f', 'https://test.instamojo.com/api/1.1/');
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => "PICDRIVE PLAN",
            "amount" => $amount,
            "buyer_name" => $fullname,
            "send_email" => true,
            "email" => $username,
            "phone" => "8788128536",
            "redirect_url" => "http://localhost/picdrive/profile/php/update_storage.php?plans=".$plans."&storage=".$storage
            ));
            $payment_url = $response['longurl'];
            header("Location:$payment_url");
    }
    catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
?>