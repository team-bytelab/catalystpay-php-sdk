<?php
require_once 'vendor/autoload.php';

use CatalystPay\CatalystPaySDK;

// Example usage
try {

    // Configured  CatalystPaySDK
    $token = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    $entityId = '8a8294174b7ecb28014b9699220015ca';
    $isProduction = false;
    $catalystPaySDK = new CatalystPaySDK(
        $token,
        $entityId,
        $isProduction
    );

    $resultTransactionById = $resultTransactionMerchant = $resultTransactionSpecifiedTimeFrame = $resultTransactionSpecifiedTimeFrame = $resultTransactionPagination = '';
    $title = '';
    $resultPaymentsByOperations = $resultCreditStandAloneRefund = [];
    // Get summary level information for a certain date and/or settlement currency
    if (isset($_POST['submit1'])) {

        // check if paymentId  
        if (isset($_POST['paymentId'])) {
            $dataPaymentsByOperations['paymentId'] = $_POST['paymentId'];
        }

        // check if amount  
        if (isset($_POST['amount'])) {
            $dataPaymentsByOperations['amount'] = $_POST['amount'];
        }

        // check if currency  
        if (isset($_POST['currency'])) {
            $dataPaymentsByOperations['currency'] = $_POST['currency'];
        }

        // check if paymentType  
        if (isset($_POST['paymentType'])) {
            $dataPaymentsByOperations['paymentType'] = $_POST['paymentType'];
        }
        $paymentsByOperations = $catalystPaySDK->paymentsByOperations($dataPaymentsByOperations);
        $resultPaymentsByOperations = $paymentsByOperations->getApiResponse();
    }
    //Get further details for a particular aggregation id.
    if (isset($_POST['submit2'])) {

        $dataPaymentsByOperations = [
            'amount' => $_POST['amount'],
            'currency' => $_POST['currency'],
            'paymentType' => $_POST['paymentType'],
            'paymentBrand' => $_POST['paymentBrand'],
            'cardNumber' => $_POST['card_number'],
            'cardExpiryMonth' => $_POST['card_expiry_month'],
            'cardExpiryYear' => $_POST['card_expiry_year'],
            'cardHolder' => $_POST['card_holder'],
        ];

        $creditStandAloneRefund = $catalystPaySDK->CreditStandAloneRefund($dataPaymentsByOperations);
        $resultCreditStandAloneRefund = $creditStandAloneRefund->getApiResponse();
    }
} catch (Exception $e) {
    echo  $e->getMessage();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice Operations</title>
    <style>
        .custom-box {
            display: none;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="row">
        <div class="col-md-12 my-5 d-flex justify-content-center align-items-center">
            <div class="form-group">
                <label><input type="radio" name="colorCheckbox" value="box1" <?php echo (isset($_POST['submit1'])) ? "checked" : ""; ?>>Payments by operations</label>
                <label><input type="radio" name="colorCheckbox" value="box2" <?php echo (isset($_POST['submit2'])) ? "checked" : ""; ?>> Credit is a independent transaction that results in a refund </label>
            </div>
        </div>
    </div>
    <div class="custom-box box1" style="<?php echo (isset($_POST['submit1'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">

                <form class="col-md-4" action="#" method="POST">
                    <div class="form-group my-2">
                        <label for="paymentId" class="text-danger"> paymentId*:</label>
                        <input type="text" class="form-control" placeholder="Enter paymentId" name="paymentId" value="8a82944a4cc25ebf014cc2c782423202" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="operations" class="text-danger"> paymentType*:</label>
                        <select name="paymentType" id="paymentType" class="form-control">
                            <option value="CP">Capture</option>
                            <option value="RF">Refund</option>
                            <option value="RV">Reversal</option>
                            <option value="RC">Receipt</option>
                        </select>
                    </div>
                    <div class="custom_dev">
                        <div class="form-group amount my-2">
                            <label for="amount" class="text-danger"> amount*:</label>
                            <input type="number" class="form-control" placeholder="Enter amount" name="amount" value="10.00" required>
                        </div>
                        <div class="form-group my-2">
                            <label for="currency" class="text-danger"> currency*:</label>
                            <input type="text" class="form-control" placeholder="Enter currency" name="currency" value="EUR">
                        </div>
                    </div>
                    <input type="submit" name="submit1" class="btn btn-primary" value="Payments by operations">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Payments by operations Api Response :</h1>
            <?php print_r($resultPaymentsByOperations); ?>
        </div>
    </div>
    <div class="custom-box box2" style="<?php echo (isset($_POST['submit2'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12  d-flex justify-content-center align-items-center">

                <form class="col-md-4" action="#" method="POST">
                    <div class="custom_dev">
                        <div class="form-group amount my-2">
                            <label for="amount" class="text-danger"> amount*:</label>
                            <input type="number" class="form-control" placeholder="Enter amount" name="amount" value="10.00" required>
                        </div>
                        <div class="form-group my-2">
                            <label for="currency" class="text-danger"> currency*:</label>
                            <input type="text" class="form-control" placeholder="Enter currency" name="currency" value="EUR" required>
                        </div>
                        <div class="form-group my-2">
                            <label for="operations" class="text-danger"> paymentType*:</label>
                            <select name="paymentType" id="paymentType" class="form-control">
                                <option value="CD">Credit</option>
                                <option value="DB">Debit</option>
                                <option value="PA.CP">Captured preauthorization</option>
                                <option value="AD">Advance</option>

                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label for="operations" class="text-danger"> paymentBrand*:</label>
                            <select name="paymentBrand" id="paymentBrand" class="form-control" required>
                                <option value="<?php echo CatalystPaySDK::PAYMENT_BRAND_VISA; ?>" selected>
                                    <?php echo CatalystPaySDK::PAYMENT_BRAND_VISA; ?></option>
                                <option value="<?php echo CatalystPaySDK::PAYMENT_BRAND_AMEX; ?>"><?php echo CatalystPaySDK::PAYMENT_BRAND_AMEX; ?></option>
                                <option value="<?php echo CatalystPaySDK::PAYMENT_BRAND_MASTERCARD; ?>"><?php echo CatalystPaySDK::PAYMENT_BRAND_MASTERCARD; ?></option>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <label for="currency" class="text-danger"> card number*:</label>
                            <input type="text" class="form-control" placeholder="Enter card number" name="card_number" value="4200000000000000" required>
                        </div>
                        <div class=" form-group my-2">
                            <label for="expiryMonth" class="text-danger"> card expiry month*:</label>
                            <input type="number" class="form-control" placeholder="Enter card expiry month" name="card_expiry_month" value="12" required>
                        </div>

                        <div class=" form-group my-2">
                            <label for="expiryYear" class="text-danger"> card expiryYear*:</label>
                            <input type="number" class="form-control" placeholder="Enter card expiry year" name="card_expiry_year" value="2025" required>
                        </div>
                        <div class=" form-group my-2">
                            <label for="holder" class="text-danger"> card holder*:</label>
                            <input type="text" class="form-control" placeholder="Enter holder" name="card_holder" value="Jane Jones" required>
                        </div>
                    </div>
                    <input type="submit" name="submit2" class="btn btn-primary" value="Credit is a independent transaction that results in a refund">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Credit is a independent transaction that results in a refund Api Response :</h1>
            <?php print_r($resultCreditStandAloneRefund); ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                $(".custom-box").hide();
                $("." + inputValue).show();
            });

            $("select[name=paymentType]").change(function() {
                if ($(this).val() == "RV") {
                    $(".custom_dev").hide();

                } else {
                    $(".custom_dev").show();
                }
            });
        });
    </script>
</body>

</html>