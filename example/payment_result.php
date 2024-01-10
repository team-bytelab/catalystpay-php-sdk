<?php
require_once 'vendor/autoload.php';

use CatalystPay\CatalystPaySDK;

// Example usage
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
        $isPaymentStatusSuccess = $paymentSDK->isPaymentStatusSuccess($responseData->getResultCode());

        // Check IF payment transaction pending is true
        if ($paymentSDK->isPaymentTransactionPending($responseData)) {
            $errorMsg = 'The transaction should be pending, but is ' . $responseData->getResultCode();
        } elseif ($paymentSDK->isPaymentRequestNotFound($responseData->getResultCode())) { // Check IF payment request not found is true
            $errorMsg = 'No payment session found for the requested id, but is ' . $responseData->getResultCode();
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div>
            <?php
            // Check if Payment Status Success
            if ($isPaymentStatusSuccess) {
            ?>

                <div class=" mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h1>Thank You !</h1>
                    <p>We've received the your payment.</p>
                    <p>
                        <b>Transaction Id:</b><span><?php echo $responseData->getId() ?? ''; ?></span><br>
                    </p>
                    <button class="btn btn-primary">Back Home</button>
                </div>
            <?php
            }
            echo $errorMsg;
            ?>
        </div>
</body>

</html>