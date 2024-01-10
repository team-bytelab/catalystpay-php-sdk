## CatalystPay SDK for PHP

#This is a PHP SDK for integrating with the CatalystPay API to handle payment processing.

### Demo video Url <https://www.screenpresso.com/=raBX>

### 1) Installation

`composer require catalystpay/catalystpay-php-sdk`

### 2) Go to root project and you can use this PaymentSDK class in your PHP code as follows

```php <?php

 require_once 'vendor/autoload.php';

use CatalystPay\CatalystPayResponse;
use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;

// Example usage
    try {
        $successMessage = $errorMessage = '';
        $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
        $entityId = '8a8294174b7ecb28014b9699220015ca';
        $isProduction = false;
        $paymentSDK = new CatalystPaySDK(
            $token,
            $entityId,
            $isProduction
        );
        $responseData = $paymentSDK->prepareCheckout(92.00, 'EUR', CatalystPaySDK::PAYMENT_TYPE_DEBIT);

        // Handle Response 
        $catalystPayResponse = new CatalystPayResponse();
        $catalystPayResponse->fromApiResponse($responseData);
        // print_r($catalystPayResponse->getResultCode());

        $isPrepareCheckoutSuccess = $paymentSDK->isPrepareCheckoutSuccess($catalystPayResponse->getResultCode());

        // Check if isPrepareCheckoutSuccess is true
        if ($isPrepareCheckoutSuccess) {
            //Show checkout success
            $infoMessage = 'The checkout returned ' . $catalystPayResponse->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT;
            $checkoutId = $catalystPayResponse->getId(); // Assuming the response contains the ID
            $shopperResultUrl = "http://localhost/catalystpay-php-sdk/payment_result.php"; // Replace with your actual URL
            sleep(5); // Wait for 5 seconds before checking the payment status
        } else {
            $errorMessage = "The Prepare Checkout was not successful";
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
```
