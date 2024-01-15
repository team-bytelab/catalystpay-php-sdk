# CatalystPay SDK for PHP

#This is a PHP SDK for integrating with the CatalystPay API to handle payment processing.

### Demo video Url <https://www.screenpresso.com/=raBX>

##  Installation

`composer require catalystpay/catalystpay-php-sdk`

## Catalyst Pay Integration Guide
### 1) Go to root project and you can use this PaymentSDK class in your PHP code as follows

```php

require_once 'vendor/autoload.php';

use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;
try {
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

    //Prepare Check out form 
    $responseData = $paymentSDK->prepareCheckout($amount, $currency, $paymentType);
    // Check if isPrepareCheckoutSuccess is true
    if ($responseData->isCheckoutSuccess()) {
        //Show checkout success
        $infoMessage = 'The checkout returned ' . $responseData->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT;
        $checkoutId = $responseData->getId(); // Assuming the response contains the ID
        $shopperResultUrl = "http://localhost/catalystpay-php-sdk/payment_result.php"; // Replace with your actual URL
        echo $paymentSDK->createPaymentForm($checkoutId, $shopperResultUrl, [CatalystPaySDK::PAYMENT_BRAND_VISA . ' ' . CatalystPaySDK::PAYMENT_BRAND_MASTERCARD . ' ' . CatalystPaySDK::PAYMENT_BRAND_AMEX]);
    } else {
        echo "The Prepare Checkout was not successful";
    }
} catch (Exception $e) {
   echo $e->getMessage();
}
```

### 2) Go to root project and you can use this PaymentSDK class to get payment status in your PHP code as follows

```php

require_once 'vendor/autoload.php';
use CatalystPay\CatalystPaySDK;

try {

    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $paymentSDK = new CatalystPaySDK(
        $token,
        $entityId,
        $isProduction
    );
    $errorMsg = '';
    // Handle the payment status as needed
    if (isset(($_GET['id']))) {
        $checkoutId = $_GET['id'];
        $responseData = $paymentSDK->getPaymentStatus($checkoutId);
        print_r($responseData->getApiResponse()); // Get payment status response 
        var_dump($responseData->isPaymentStatus()); // Check  payment status value True or False

        // Check IF payment  status is success 
        if ($responseData->isPaymentStatus()) {

            // Check IF payment transaction pending is true
            if ($responseData->isPaymentTransactionPending()) {
                echo 'The transaction should be pending, but is ' . $responseData->getResultCode();
            } elseif ($responseData->isPaymentRequestNotFound()) { // Check IF payment request not found is true
                echo'No payment session found for the requested id, but is ' . $responseData->getResultCode();
            }
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

```

## Catalyst Pay Registration Tokens

### 1) Go to root project and you can use this PaymentSDK class for Prepare the checkout and create the registration form in your PHP code as follows

```php
require_once 'vendor/autoload.php';
use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;

try {
    // Configured  CatalystPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $isCreateRegistration = 'true';
    $paymentSDK = new CatalystPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    // Form Values defined variable
    $data = [
        'testMode' => CatalystPaySDK::TEST_MODE_EXTERNAL,
        'createRegistration' => $isCreateRegistration
    ];
    //Prepare Check out form 
    $responseData = $paymentSDK->prepareRegisterCheckout($data);

    //  print_r($responseData);
    // var_dump($responseData->isCheckoutSuccess());
    // Check if checkout success is true
    if ($responseData->isCheckoutSuccess()) {
        //Show checkout success
        $infoMessage = 'The checkout returned ' . $responseData->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT;
        $checkoutId = $responseData->getId(); // Assuming the response contains the ID
        $shopperResultUrl = "http://localhost/catalystpay-php-sdk/register_payment_result.php"; // Replace with your actual URL
        echo $paymentSDK->getCreateRegistrationPaymentForm($checkoutId, $shopperResultUrl, [CatalystPaySDK::PAYMENT_BRAND_VISA . ' ' . CatalystPaySDK::PAYMENT_BRAND_MASTERCARD . ' ' . CatalystPaySDK::PAYMENT_BRAND_AMEX]);
    } else {
        echo "The Prepare Checkout was not successful";
    }
} catch (Exception $e) {
   echo $e->getMessage();
} 
```


### 2) Go to root project and you can use this PaymentSDK class to get the registration status and Send payment using the token in your PHP code as follows

```php
// Example usage
try {
    $errorMsg = '';
    $isPaymentSuccessful = false;
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $paymentSDK = new CatalystPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    // Handle the payment Registration status as needed
    if (isset(($_GET['id']))) {
        $checkoutId = $_GET['id'];
        $responseData = $paymentSDK->getRegistrationStatus($checkoutId);
        print_r($responseData->getApiResponse()); // Get payment Registration status response 
        var_dump($responseData->isRegistrationStatus()); // Check  payment Registration status value True or False

        // Check IF payment registration status is success 
        if ($responseData->isRegistrationStatus()) {
            $paymentId = $responseData->getId(); // get the payment id

            // Form Values defined variable
            $data = [
                'paymentBrand' => CatalystPaySDK::PAYMENT_BRAND_VISA,
                'paymentType' =>  CatalystPaySDK::PAYMENT_TYPE_DEBIT,
                'amount' => 92.00,
                'currency' => 'EUR',
                'standingInstructionType' =>  CatalystPaySDK::STANDING_INSTRUCTION_TYPE_UNSCHEDULED,
                'standingInstructionMode' =>  CatalystPaySDK::STANDING_INSTRUCTION_MODE_INITIAL,
                'standingInstructionSource' => CatalystPaySDK::STANDING_INSTRUCTION_SOURCE_CIT,
                'testMode' => CatalystPaySDK::TEST_MODE_EXTERNAL
            ];

            // Send payment using the token
            $registerPayment = $paymentSDK->sendRegisterPayment($paymentId, $data);

            //check if payment Successful true
            $isPaymentSuccessful =  $registerPayment->isPaymentSuccessful();

            print_r($registerPayment->getApiResponse()); // Get send payment Registration response
            // Check IF payment transaction pending is true
            if ($registerPayment->isPaymentTransactionPending()) {
               echo'The transaction should be pending, but is ' . $registerPayment->getResultCode();
            } elseif ($registerPayment->isPaymentRequestNotFound()) { // Check IF payment request not found is true
               echo 'No payment session found for the requested id, but is ' . $registerPayment->getResultCode();
            }
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```