<?php
require_once 'vendor/autoload.php';

use CatalystPay\CatalystPaySDK;

// Example usage
try {

    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $paymentSDK = new CatalystPaySDK(
        $token,
        $entityId,
        $isProduction
    );
    $responseData = $paymentSDK->prepareCheckout(92.00, 'EUR', CatalystPaySDK::PAYMENT_TYPE_DEBIT);

    $isPrepareCheckoutSuccess = $paymentSDK->isPrepareCheckoutSuccess($responseData['result']['code']);
    // Check if isPrepareCheckoutSuccess is true
    if ($isPrepareCheckoutSuccess) {
        $checkoutId = $responseData['id']; // Assuming the response contains the ID
        $shopperResultUrl = "http://localhost/catalystpay-php-sdk/payment_result.php"; // Replace with your actual URL
        echo $paymentSDK->createPaymentForm($checkoutId, $shopperResultUrl, [CatalystPaySDK::PAYMENT_BRAND_VISA . ' ' . CatalystPaySDK::PAYMENT_BRAND_MASTERCARD . ' ' . CatalystPaySDK::PAYMENT_BRAND_AMEX]);
        // Example: Wait for the payment status
        sleep(5); // Wait for 5 seconds before checking the payment status
    } else {
        echo "The Prepare Checkout was not successful";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
