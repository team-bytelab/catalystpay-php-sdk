## CatalystPay SDK for PHP

#This is a PHP SDK for integrating with the CatalystPay API to handle payment processing.

### Demo video Url <https://www.screenpresso.com/=raBX>

### 1) Installation

`composer require catalystpay/catalystpay-php-sdk`

### 2) Go to root project and you can use this PaymentSDK class in your PHP code as follows

```php <?php

require_once 'vendor/autoload.php';

use CatalystPay\PaymentSDK;

// Example usage
try {

    $baseUrl = 'https://eu-test.oppwa.com/';
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isDevelopment = false;
    $paymentSDK = new PaymentSDK(
        $baseUrl,
        $token,
        $entityId,
        $isDevelopment
    );

    $responseData = $paymentSDK->prepareCheckout(92.00, 'EUR', 'DB');
    $checkoutId = $responseData['id']; // Assuming the response contains the ID

    $shopperResultUrl = "https://example.com/payment_result"; // Replace with your actual URL

    echo $paymentSDK->createPaymentForm($checkoutId, $shopperResultUrl);

    // Example: Wait for the payment status
    sleep(5); // Wait for 5 seconds before checking the payment status

    $paymentStatus = $paymentSDK->getPaymentStatus($checkoutId);
    var_dump($paymentStatus); // Handle the payment status as needed
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```
