<?php
require_once 'vendor/autoload.php';

use CatalystPay\PaymentSDK;

// Example usage
try {

    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isDevelopment = false;
    $paymentSDK = new PaymentSDK(
        $token,
        $entityId,
        $isDevelopment
    );

    $responseData = $paymentSDK->prepareCheckout(92.00, 'EUR', 'DB');
    $checkoutId = $responseData['id']; // Assuming the response contains the ID
    // print_r($responseData);

    $shopperResultUrl = "http://localhost/catalystpay-php-sdk/payment_result.php"; // Replace with your actual URL

    echo $paymentSDK->createPaymentForm($checkoutId, $shopperResultUrl, ['VISA MASTER AMEX']);

    // // Example: Wait for the payment status
    sleep(5); // Wait for 5 seconds before checking the payment status


} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
