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
     * @param array  $data  The payment data like amount,currency , paymentType etc.
     * 
     * @return array The decoded JSON response.
     */
    public function prepareCheckout($data = [])
    {
        // Form Data
        $baseOptions = [
            "entityId" => $this->entityId,
            "amount" => $data['amount'],
            "currency" => $data['currency'],
            "paymentType" => $data['paymentType'],
        ];

        // check if billing city
        if (isset($data['billing.city'])) {
            $baseOptions['billing.city'] = $data['billing.city'];
        }
        // check if billing country
        if (isset($data['billing.country'])) {
            $baseOptions['billing.country'] = $data['billing.country'];
        }
        // check if billing street1
        if (isset($data['billing.street1'])) {
            $baseOptions['billing.street1'] = $data['billing.street1'];
        }
        // check if billing postcode
        if (isset($data['billing.postcode'])) {
            $baseOptions['billing.postcode'] = $data['billing.postcode'];
        }

        // check if billing city
        if (isset($data['billing.city'])) {
            $baseOptions['billing.city'] = $data['billing.city'];
        }
        // check if customer email
        if (isset($data['customer.email'])) {
            $baseOptions['customer.email'] = $data['customer.email'];
        }
        // check if customer.givenName
        if (isset($data['customer.givenName'])) {
            $baseOptions['customer.givenName'] = $data['customer.givenName'];
        }
        // check if customer surname
        if (isset($data['customer.surname'])) {
            $baseOptions['customer.surname'] = $data['customer.surname'];
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Payment with card.
     *
     * @param array  $data  The payment data like amount,currency paymentType etc.
     * @return array The decoded JSON response.
     */
    public function payCard($data = [])
    {
        $data['entityId'] = $this->entityId;
        $url = $this->baseUrl . '/v1' . CatalystPaySDK::URI_PAYMENTS;
        $response =  $this->doPOST($url, $data, $this->isProduction, $this->token);
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
