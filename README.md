## CatalystPay SDK for PHP

#This is a PHP SDK for integrating with the CatalystPay API to handle payment processing.

### Demo video Url <https://www.screenpresso.com/=raBX>

### 1) Installation

`composer require catalystpay/catalystpay-php-sdk`

### 2) Go to root project and you can use this PaymentSDK class in your PHP code as follows

```php <?php

require_once 'vendor/autoload.php';

use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;

// Example usage
try {
    $successMessage = $errorMessage = '';

    // Configured  CatalystPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $paymentSDK = new CatalystPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    // Form Values defined variable
    $amount = 92.00;
    $currency = 'EUR';
    $paymentType = CatalystPaySDK::PAYMENT_TYPE_DEBIT;

    // Form Data
    $formData = "&amount=" .  $amount .
        "&currency=" . $currency .
        "&paymentType=" . $paymentType;
    $responseData = $paymentSDK->prepareCheckout($formData);
    $isPrepareCheckoutSuccess = $paymentSDK->isPrepareCheckoutSuccess($responseData->getResultCode());

    // Check if isPrepareCheckoutSuccess is true
    if ($isPrepareCheckoutSuccess) {
        //Show checkout success
        $infoMessage = 'The checkout returned ' . $responseData->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT;
        $checkoutId = $responseData->getId(); // Assuming the response contains the ID
        $shopperResultUrl = "http://localhost/catalystpay-php-sdk/payment_result.php"; // Replace with your actual URL
        echo $paymentSDK->createPaymentForm($checkoutId, $shopperResultUrl, [CatalystPaySDK::PAYMENT_BRAND_VISA . ' ' . CatalystPaySDK::PAYMENT_BRAND_MASTERCARD . ' ' . CatalystPaySDK::PAYMENT_BRAND_AMEX]);
    } else {
        $errorMessage = "The Prepare Checkout was not successful";
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
```
