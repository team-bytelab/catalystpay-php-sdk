<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * Trait CopyAndPayCheckout
 * This trait provides methods to interact with the CatalystPay CopyAndPay Checkout API.
 */
trait CopyAndPayCheckout
{
    use PerformsPOST, PerformsGET;

    /**
     * Prepares a new checkout.
     *
     * @param float  $amount      The amount of the payment.
     * @param string $currency    The currency of the payment.
     * @param string $paymentType The type of payment (e.g., DB, CD).
     *
     * @return array The decoded JSON response.
     */
    public function prepareCheckout($amount, $currency, $paymentType)
    {
        // Form Data
        $baseOptions = [
            "entityId" => $this->entityId,
            "amount" => $amount,
            "currency" => $currency,
            "paymentType" => $paymentType,
        ];

        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Get the payment status for a checkout.
     *
     * @param string $checkoutId The ID of the checkout.
     * @return string The URL to check the payment status.
     */
    public function getPaymentStatus($checkoutId)
    {
        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS . '/' . $checkoutId . CatalystPaySDK::URI_PAYMENT . '?entityId=' . $this->entityId;
        $response =  $this->doGET($url, $this->isProduction, $this->token);
        return $response;
    }
}
