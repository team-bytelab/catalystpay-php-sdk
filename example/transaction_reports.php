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
    $dataTransaction = $dataTransactionSpecifiedTimeFrame = [];
    // Get Transaction by id
    if (isset($_POST['submit1'])) {

        $dataTransaction['id'] = $_POST['id']; // transaction id 

        // check if paymentTypes  
        if (isset($_POST['paymentTypes'])) {
            $dataTransaction['paymentTypes'] = $_POST['paymentTypes'];
        }

        // check if paymentMethods   
        if (isset($_POST['paymentMethods '])) {
            $dataTransaction['paymentMethods '] = $_POST['paymentMethods '];
        }

        // check if includeLinkedTransactions is true
        if (isset($_POST['includeLinkedTransactions'])) {
            $dataTransaction['includeLinkedTransactions'] = $_POST['includeLinkedTransactions'];
        }

        $responseData = $catalystPaySDK->getTransactionById($dataTransaction);
        $resultTransactionById = $responseData->getApiResponse(); // Get Transaction response 
    }

    // Get Transaction by merchant ID 
    if (isset($_POST['submit2'])) {
        $merchantTransactionId = $_POST['merchantTransactionId']; // transaction id 
        $transactionMerchant = $catalystPaySDK->getMerchantTransactionById($merchantTransactionId);
        $resultTransactionMerchant = $transactionMerchant->getApiResponse();
    }

    // Get transactions for a specified time frame
    if (isset($_POST['submit3'])) {
        $dataTransactionSpecifiedTimeFrame['dateFrom'] = $_POST['dateFrom'];
        $dataTransactionSpecifiedTimeFrame['dateTo'] = $_POST['dateTo'];

        // check if paymentTypes  
        if (isset($_POST['paymentTypes'])) {
            $dataTransaction['paymentTypes'] = $_POST['paymentTypes'];
        }

        // check if paymentMethods   
        if (isset($_POST['paymentMethods '])) {
            $dataTransaction['paymentMethods '] = $_POST['paymentMethods '];
        }

        // check if limit  
        if (isset($_POST['limit'])) {
            $dataTransaction['limit'] = $_POST['limit'];
        }

        // check if merchantTransactionId  
        if (isset($_POST['merchantTransactionId'])) {
            $merchantTransactionId = $_POST['merchantTransactionId']; // transaction id 
        }
        $transactionSpecifiedTimeFrame = $catalystPaySDK->getTransactionByDateFilter($dataTransactionSpecifiedTimeFrame);
        $resultTransactionSpecifiedTimeFrame = $transactionSpecifiedTimeFrame->getApiResponse();
    }
    // Get transactions for a specified time frame with pagination
    if (isset($_POST['submit4'])) {
        $dataTransactionPagination['dateFrom'] = $_POST['dateFrom'];
        $dataTransactionPagination['dateTo'] = $_POST['dateTo'];

        // check if merchantTransactionId  
        if (isset($_POST['merchantTransactionId'])) {
            $merchantTransactionId = $_POST['merchantTransactionId']; // transaction id 
        }
        // check if paymentTypes  
        if (isset($_POST['paymentTypes'])) {
            $dataTransaction['paymentTypes'] = $_POST['paymentTypes'];
        }

        // check if paymentMethods   
        if (isset($_POST['paymentMethods '])) {
            $dataTransaction['paymentMethods '] = $_POST['paymentMethods '];
        }

        // check if limit  
        if (isset($_POST['limit'])) {
            $dataTransaction['limit'] = $_POST['limit'];
        }
        // check if pageNo  
        if (isset($_POST['pageNo'])) {
            $dataTransactionPagination['pageNo'] = $_POST['pageNo'];
        }

        $transactionPagination = $catalystPaySDK->getTransactionByDateWithPagination($dataTransactionPagination);
        $resultTransactionPagination = $transactionPagination->getApiResponse();
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
                <label><input type="radio" name="colorCheckbox" value="box1" <?php echo (isset($_POST['submit1'])) ? "checked" : ""; ?>> Get transaction by id</label>
                <label><input type="radio" name="colorCheckbox" value="box2" <?php echo (isset($_POST['submit2'])) ? "checked" : ""; ?>> Get transaction using your order reference</label>
                <label><input type="radio" name="colorCheckbox" value="box3" <?php echo (isset($_POST['submit3'])) ? "checked" : ""; ?>> Get transactions for a specified time frame</label>
                <label><input type="radio" name="colorCheckbox" value="box4" <?php echo (isset($_POST['submit4'])) ? "checked" : ""; ?>> Get transactions for a specified time frame with pagination</label>
            </div>
        </div>
    </div>
    <div class="custom-box box1" style="<?php echo (isset($_POST['submit1'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">

                <form class="col-md-4" action="#" method="POST">
                    <div class="form-group">
                        <label for="id" class="text-danger"> id*:</label>
                        <input type="text" class="form-control" placeholder="Enter id" name="id" value="8ac7a4a1845f7e19018461a00b366a74" required>
                    </div>
                    <div class="form-group">
                        <label for="id"> paymentTypes:</label>
                        <input type="text" class="form-control" placeholder="Enter paymentTypes" name="paymentTypes" value="DB,3D">
                    </div>
                    <div class="form-group">
                        <label for="id"> paymentMethods :</label>
                        <input type="text" class="form-control" placeholder="Enter paymentMethods" name="paymentMethods" value="CC,DC">
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input type="checkbox" name="includeLinkedTransactions" value="true"> includeLinkedTransactions</label>
                        </div>
                    </div>

                    <input type="submit" name="submit1" class="btn btn-primary" value="Get transaction by id">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Get Transaction by id Api Response :</h1>
            <?php print_r($resultTransactionById); ?>
        </div>
    </div>
    <div class="custom-box box2" style="<?php echo (isset($_POST['submit2'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">

                <form class="col-md-4" action="#" method="POST">
                    <div class="form-group my-2">
                        <label for="merchantTransactionId" class="text-danger"> merchantTransactionId*:</label>
                        <input type="text" class="form-control" placeholder="Enter merchantTransactionId" name="merchantTransactionId" value="test123" required>
                    </div>
                    <input type="submit" name="submit2" class="btn btn-secondary" value="Get transaction using your order reference">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Get Transaction by merchant ID Api Response :</h1>
            <?php print_r($resultTransactionMerchant); ?>
        </div>
    </div>
    <div class="custom-box box3" style="<?php echo (isset($_POST['submit3'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">
                <form class="col-md-4" action="#" method="POST">
                    <div class="form-group my-2">
                        <label for="dateFrom" class="text-danger"> dateFrom*:</label>
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="dateFrom" value="2023-01-01 00:00:00" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="dateTo" class="text-danger"> dateTo*:</label>
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="dateTo" value="2023-01-01 01:00:00" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="merchantTransactionId"> merchantTransactionId:</label>
                        <input type="text" class="form-control" placeholder="Enter merchantTransactionId" name="merchantTransactionId" value="test123" required>
                    </div>
                    <div class="form-group">
                        <label for="id"> paymentTypes:</label>
                        <input type="text" class="form-control" placeholder="Enter paymentTypes" name="paymentTypes" value="DB,3D">
                    </div>
                    <div class="form-group">
                        <label for="id"> paymentMethods :</label>
                        <input type="text" class="form-control" placeholder="Enter paymentMethods" name="paymentMethods" value="CC,DC">
                    </div>
                    <div class="form-group my-2">
                        <label for="limit"> limit:</label>
                        <input type="text" class="form-control" placeholder="Enter limit" name="limit" value="20">
                    </div>
                    <input type="submit" name="submit3" class="btn btn-info" value="Get transactions for a specified time frame">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Get transactions for a specified time frame Api Response:</h1>
            <?php print_r($resultTransactionSpecifiedTimeFrame); ?>
        </div>
    </div>
    <div class="custom-box box4" style="<?php echo (isset($_POST['submit4'])) ? 'display: block;' : ''; ?>">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center">
                <form action="#" method="POST">
                    <div class="form-group my-2">
                        <label for="dateFrom" class="text-danger"> dateFrom*:</label>
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="dateFrom" value="2023-01-01 00:00:00" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="dateTo" class="text-danger"> dateTo*:</label>
                        <input type="text" class="form-control" placeholder="YYYY-MM-DD HH:MM:SS" name="dateTo" value="2023-01-01 01:00:00" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="merchantTransactionId"> merchantTransactionId:</label>
                        <input type="text" class="form-control" placeholder="Enter merchantTransactionId" name="merchantTransactionId" value="test123" required>
                    </div>
                    <div class="form-group">
                        <label for="id"> paymentTypes:</label>
                        <input type="text" class="form-control" placeholder="Enter paymentTypes" name="paymentTypes" value="DB,3D">
                    </div>
                    <div class="form-group">
                        <label for="id"> paymentMethods :</label>
                        <input type="text" class="form-control" placeholder="Enter paymentMethods" name="paymentMethods" value="CC,DC">
                    </div>
                    <div class="form-group my-2">
                        <label for="limit"> limit:</label>
                        <input type="text" class="form-control" placeholder="Enter limit" name="limit" value="20">
                    </div>
                    <div class="form-group my-2">
                        <label for="pageNo" class="text-danger"> pageNo*:</label>
                        <input type="text" class="form-control" placeholder="Enter pageNo" name="pageNo" value="2">
                    </div>
                    <input type="submit" name="submit4" class="btn btn-success" value="Get transactions for a specified time frame with pagination">
                </form>
            </div>
        </div>
        <div class="row m-5">
            <h1>Get transactions for a specified time frame with pagination Api Response :</h1>
            <?php print_r($resultTransactionPagination); ?>
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
        });
    </script>
</body>

</html>