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
            $infoMessage = $errorMessage = '';

            // Configured  CatalystPaySDK
            $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
            $entityId = '8a8294174b7ecb28014b9699220015ca';
            $isProduction = false;
            $isCreateRegistration = true;
            $paymentSDK = new CatalystPaySDK(
                $token,
                $entityId,
                $isProduction,
                $isCreateRegistration
            );

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
            //Prepare Check out form 
            $responseData = $paymentSDK->prepareRegisterCheckout($data);


            // $responsePayment =  $paymentSDK->sendRegisterPayment($checkoutId, $data);
            // print_r($responsePayment);
            // exit;
            $isPrepareCheckoutSuccess = $paymentSDK->isPrepareCheckoutSuccess($responseData->getResultCode());

            // Check if isPrepareCheckoutSuccess is true
            if ($isPrepareCheckoutSuccess) {
                //Show checkout success
                $infoMessage = 'The checkout returned ' . $responseData->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT;
                $checkoutId = $responseData->getId(); // Assuming the response contains the ID
                $shopperResultUrl = "http://localhost/catalystpay-php-sdk/register_payment_result.php"; // Replace with your actual URL
                echo $paymentSDK->getCreateRegistrationPaymentForm($checkoutId, $shopperResultUrl, [CatalystPaySDK::PAYMENT_BRAND_VISA . ' ' . CatalystPaySDK::PAYMENT_BRAND_MASTERCARD . ' ' . CatalystPaySDK::PAYMENT_BRAND_AMEX]);
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