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

    // Get summary level information for a certain date and/or settlement currency
    $settlementReportBySummary = $catalystPaySDK->getSettlementReportBySummary('2015-08-01', '2015-08-02', 'EUR', CatalystPaySDK::TEST_MODE_INTERNAL);
    print_r($settlementReportBySummary->getApiResponse());

    //Get further details for a particular aggregation id.
    $responseData = $catalystPaySDK->getDetailLevelById('8a82944a4cc25ebf014cc2c782423202', CatalystPaySDK::TEST_MODE_INTERNAL);
    print_r($responseData->getApiResponse());

    // Get detail level with pagination
    $settlementReportPagination = $catalystPaySDK->getDetailLevelByIdWithPagination('8a82944a4cc25ebf014cc2c782423202', CatalystPaySDK::TEST_MODE_INTERNAL, 2);
    print_r($settlementReportPagination);
} catch (Exception $e) {
    echo  $e->getMessage();
}
