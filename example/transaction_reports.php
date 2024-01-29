<?php
require_once 'vendor/autoload.php';

use CatalystPay\CatalystPaySDK;

// Example usage
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

    $result = '';
    $title = '';
    // Get Transaction by id
    if (isset($_POST['submit1'])) {
        $title = 'Get Transaction by id';
        $responseData = $paymentSDK->getTransactionById('8ac7a4a1845f7e19018461a00b366a74', 'true', 'DB,3D');
        $result = $responseData->getApiResponse(); // Get Transaction response 
    }

    // Get Transaction by merchant ID 
    if (isset($_POST['submit2'])) {
        $title = 'Get Transaction by merchant ID ';
        $transactionMerchant = $paymentSDK->getMerchantTransactionById('test123');
        $result = $transactionMerchant->getApiResponse();
    }

    // Get transactions for a specified time frame
    if (isset($_POST['submit3'])) {
        $title = 'Get transactions for a specified time frame';
        $transactionSpecifiedTimeFrame = $paymentSDK->getTransactionByDateFilter('2023-01-01 00:00:00', '2023-01-01 01:00:00', 20);
        $result = $transactionSpecifiedTimeFrame->getApiResponse();
    }
    // Get transactions for a specified time frame with pagination
    if (isset($_POST['submit4'])) {
        $title = 'Get transactions for a specified time frame with pagination';
        $transactionPagination = $paymentSDK->getTransactionByDateWithPagination('2023-01-01 00:00:00', '2023-01-01 01:00:00',  2);
        $result = $transactionPagination->getApiResponse();
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
    <title>Transaction Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="row">
        <div class="col-md-12 m-5 d-flex justify-content-center align-items-center">
            <form action="#" method="POST">
                <input type="submit" name="submit1" class="btn btn-primary" value="Get transaction by id">
                <input type="submit" name="submit2" class="btn btn-secondary" value="Get transaction using your order reference">
                <input type="submit" name="submit3" class="btn btn-info" value="Get transactions for a specified time frame">
                <input type="submit" name="submit4" class="btn btn-success" value="Get transactions for a specified time frame with pagination">
            </form>
        </div>
    </div>
    <div class="row m-5">
        <h1><?php echo $title; ?> Api Response :</h1>
        <?php print_r($result); ?>
    </div>
</body>

</html>