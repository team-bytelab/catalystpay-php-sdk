<?php
require_once 'vendor/autoload.php';

use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <?php

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
        } ?>
        <div class="row">
            <div class="col-md-12">
                <?php

                //Show info Message
                if ($infoMessage !== "") { ?> <div class="alert alert-info">
                        <strong>Info!</strong>
                        <?php echo $infoMessage; ?>
                    </div>
                <?php
                }

                //Show Error Message
                if ($errorMessage !== "") { ?>
                    <div class="alert alert-danger">
                        <strong>Danger!</strong> <?php echo $errorMessage; ?>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </div>
</body>

</html>