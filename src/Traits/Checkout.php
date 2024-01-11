<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPayResponse;
use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * Trait Checkout
 * This trait provides methods to interact with the CatalystPay checkout API.
 */
trait Checkout
{
    use PerformsPOST;

    /**
     * Prepare a checkout request.
     *
     * @param string $formData The form Data.
     * @return CatalystPayResponse The API response.
     */
    public function prepareCheckout($amount, $currency, $paymentType)
    {
        // Form Data
        $baseOptions = "entityId=" . $this->entityId .
            "&amount=" .  $amount .
            "&currency=" . $currency .
            "&paymentType=" . $paymentType;
        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Check if the prepareCheckout request was successful.
     *
     * @param $response The API response to check.
     * @return bool Whether the request was successful.
     */
    public function isPrepareCheckoutSuccess($code)
    {
        return $code === CatalystPayResponseCode::CREATED_CHECKOUT;
    }
}
