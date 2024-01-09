<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;

/**
 * Trait InteractsWithPayment
 * This trait provides methods to interact with the CatalystPay payment API.
 */
trait InteractsWithPayment
{
    use PerformsGET;

    /**
     * Get the payment status for a checkout.
     *
     * @param string $checkoutId The ID of the checkout.
     * @return string The URL to check the payment status.
     */
    public function getPaymentStatus($checkoutId)
    {
        return $this->getCheckoutPaymentStatusUrl($checkoutId);
    }

    /**
     * Get the URL to check the payment status for a checkout.
     *
     * @param string $checkoutId The ID of the checkout.
     * @return string The URL to check the payment status.
     */
    public function getCheckoutPaymentStatusUrl($checkoutId)
    {
        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS . '/' . $checkoutId . CatalystPaySDK::URI_PAYMENT . '?entityId=' . $this->entityId;
        $response =  $this->doGET($url, $this->isProduction, $this->token);
        return $response;
    }
}
