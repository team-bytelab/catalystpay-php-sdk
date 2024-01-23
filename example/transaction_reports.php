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

    // Get Transaction by id
    $responseData = $paymentSDK->getTransactionById('8ac7a4a1845f7e19018461a00b366a74', 'true', 'DB,3D');
    print_r($responseData->getApiResponse()); // Get Transaction response 

    // Get Transaction by merchant ID 
    $transactionMerchant = $paymentSDK->getMerchantTransactionById('test123');
    print_r($transactionMerchant->getApiResponse());

    // Get transactions for a specified time frame
    $transactionSpecifiedTimeFrame = $paymentSDK->getTransactionByDateFilter('2023-01-01 00:00:00', '2023-01-01 01:00:00', 20);
    print_r($transactionSpecifiedTimeFrame->getApiResponse());

    // Get transactions for a specified time frame with pagination
    $transactionPagination = $paymentSDK->getTransactionByDateWithPagination('2023-01-01 00:00:00', '2023-01-01 01:00:00',  2);
    print_r($transactionPagination);
} catch (Exception $e) {
    echo  $e->getMessage();
}
