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
    $result = '';
    $title = '';
    // Get summary level information for a certain date and/or settlement currency
    if (isset($_POST['submit1'])) {
        $settlementReportBySummary = $catalystPaySDK->getSettlementReportBySummary('2015-08-01', '2015-08-02', 'EUR', CatalystPaySDK::TEST_MODE_INTERNAL);
        $result = $settlementReportBySummary->getApiResponse();
        $title = 'Get Detail Level';
    }
    //Get further details for a particular aggregation id.
    if (isset($_POST['submit2'])) {
        $title = 'Get Summary Level';
        $responseData = $catalystPaySDK->getDetailLevelById('8a82944a4cc25ebf014cc2c782423202', CatalystPaySDK::TEST_MODE_INTERNAL);
        $result = $responseData->getApiResponse();
    }
    // Get detail level with pagination
    if (isset($_POST['submit3'])) {
        $title = 'Get Detail Level with Pagination';
        $settlementReportPagination = $catalystPaySDK->getDetailLevelByIdWithPagination('8a82944a4cc25ebf014cc2c782423202', CatalystPaySDK::TEST_MODE_INTERNAL, 2);
        $result = $settlementReportPagination->getApiResponse();
    }
} catch (Exception $e) {
    echo  $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settlement tReport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="row">
        <div class="col-md-12 m-5 d-flex justify-content-center align-items-center">
            <form action="#" method="POST">
                <input type="submit" name="submit1" class="btn btn-primary" value="Get Detail Level">
                <input type="submit" name="submit2" class="btn btn-secondary" value="Get Summary Level">
                <input type="submit" name="submit3" class="btn btn-info" value="Get Detail Level with Pagination">
            </form>

        </div>
    </div>
    <div class="row m-5">
        <h1><?php echo $title; ?> Api Response :</h1>
        <?php print_r($result); ?>
    </div>
</body>

</html>