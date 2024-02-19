<?php
require_once 'vendor/autoload.php';

use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CopyAndPay</title>
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
            $catalystPaySDK = new CatalystPaySDK(
                $token,
                $entityId,
                $isProduction
            );
            if (isset($_POST['submit'])) {
                // Form Values defined variable
                $data = [
                    'amount' => 92.00,
                    'currency' => 'EUR',
                    'paymentType' => CatalystPaySDK::PAYMENT_TYPE_DEBIT,
                    'billing.city' => $_POST['billing_city'],
                    'billing.country' => $_POST['billing_country'],
                    'billing.street1' => $_POST['billing_street1'],
                    'billing.postcode' => $_POST['billing_postcode'],
                    'customer.email' => $_POST['customer_email'],
                    'customer.givenName' => $_POST['customer_givenName'],
                    'customer.surname' => $_POST['customer_surname'],
                    'customer.ip' => $_POST['customer_ip'],
                ];

                //Prepare Check out form 
                $responseData = $catalystPaySDK->prepareCheckout($data);

                // Check if isPrepareCheckoutSuccess is true
                if ($responseData->isCheckoutSuccess()) {
                    //Show checkout success
                    $infoMessage = 'The checkout returned ' . $responseData->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT;
                    $wpwlOptions = $_POST['wpwlOptions'];

                    // Payment with card
                    $formData = [
                        'checkoutId' => $responseData->getId(),
                        'shopperResultUrl' => 'http://localhost/catalystpay-php-sdk/copy_and_pay_result.php',
                        'dataBrands' => [
                            CatalystPaySDK::PAYMENT_BRAND_VISA,
                            CatalystPaySDK::PAYMENT_BRAND_MASTERCARD,
                            CatalystPaySDK::PAYMENT_BRAND_AMEX
                        ],
                        'wpwlOptions' => $wpwlOptions
                    ];
                    echo $catalystPaySDK->createPaymentForm($formData);

                    // Payment with google pay
                    $formData2 = [
                        'checkoutId' => $responseData->getId(),
                        'shopperResultUrl' => 'http://localhost/catalystpay-php-sdk/copy_and_pay_result.php',
                        'dataBrands' => [CatalystPaySDK::PAYMENT_BRAND_GOOGLE_PAY],
                        'wpwlOptions' => $wpwlOptions
                    ];
                    echo $catalystPaySDK->createPaymentForm($formData2);

                    // Payment with rocket fuel
                    $formData4 = [
                        'checkoutId' => $responseData->getId(),
                        'shopperResultUrl' => 'http://localhost/catalystpay-php-sdk/copy_and_pay_result.php',
                        'dataBrands' => [CatalystPaySDK::PAYMENT_BRAND_ROCKET_FUEL],
                        'wpwlOptions' => $wpwlOptions
                    ];
                    echo $catalystPaySDK->createPaymentForm($formData4);
                } else {
                    $errorMessage = "The Prepare Checkout was not successful";
                }
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
        ?>
        <div class="custom-box box3" style="<?php echo (isset($_POST['submit'])) ? 'display: none;' : ''; ?>">
            <div class="row m-5">
                <h1> Additional Details:</h1>

            </div>
            <div class="row">
                <div class="col-md-8 d-flex justify-content-center align-items-center">
                    <form action="#" method="POST">
                        <div class="form-group my-2">
                            <label for="id"> wpwlOptions:</label>
                            <textarea class="form-control" name="wpwlOptions" id="wpwlOptions" cols="30" rows="10">{
                            iframeStyles: {
                                'card-number-placeholder': {
                                    'color': '#ff0000',
                                    'font-size': '16px',
                                    'font-family': 'monospace'
                                },
                                'cvv-placeholder': {
                                    'color': '#0000ff',
                                    'font-size': '16px',
                                    'font-family': 'Arial'
                                }
                            }
                        }</textarea>
                        </div>
                        <div class="form-group my-2">
                            <label for="id"> billing city:</label>
                            <input type="text" class="form-control" placeholder="Enter billing city" name="billing_city" value="Denmark">
                        </div>
                        <div class="form-group my-2">
                            <label for="billing_country"> billing country :</label>
                            <input type="text" class="form-control" placeholder="Enter billing country" name="billing_country" value="DE">
                        </div>
                        <div class="form-group my-2">
                            <label for="billing_street1"> billing street1:</label>
                            <input type="text" class="form-control" placeholder="Enter billing street1" name="billing_street1" value="Will street">
                        </div>
                        <div class="form-group my-2">
                            <label for="postcode"> billing postcode:</label>
                            <input type="text" class="form-control" placeholder="Enter postcode" name="billing_postcode" value="394251">
                        </div>
                        <div class="form-group my-2">
                            <label for="customer_email"> customer email:</label>
                            <input type="text" class="form-control" placeholder="Enter customer email" name="customer_email" value="demo.test.dev@yopmail.com">
                        </div>
                        <div class="form-group my-2">
                            <label for="customer_givenName"> customer givenName:</label>
                            <input type="text" class="form-control" placeholder="Enter customer givenName" name="customer_givenName" value="John">
                        </div>
                        <div class="form-group my-2">
                            <label for="customer_surname"> customer surname:</label>
                            <input type="text" class="form-control" placeholder="Enter customer surname" name="customer_surname" value="smith">
                        </div>
                        <div class="form-group my-2">
                            <label for="customer_ip"> customer ip:</label>
                            <input type="text" class="form-control" placeholder="Enter customer ip" name="customer_ip" value="192.168.0.1">
                        </div>
                        <input type="submit" name="submit" class="btn btn-info" value="Checkout">
                    </form>
                </div>
            </div>

        </div>
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