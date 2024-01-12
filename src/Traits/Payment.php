<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPayResponse;
use CatalystPay\CatalystPayResponseCode;
use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;

/**
 * Trait Payment
 * This trait provides methods to interact with the CatalystPay payment API.
 */
trait Payment
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
        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS . '/' . $checkoutId . CatalystPaySDK::URI_PAYMENT . '?entityId=' . $this->entityId;
        return $this->getCheckoutPaymentStatusUrl($url, $checkoutId);
    }


    /**
     * Get the registration status for a checkout.
     *
     * @param string $checkoutId The ID of the payment.
     * @return string The URL to check the payment status.
     */
    public function getRegistrationStatus($checkoutId)
    {
        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS . '/' . $checkoutId . CatalystPaySDK::URI_REGISTRATION . '?entityId=' . $this->entityId;
        return $this->getCheckoutPaymentStatusUrl($url);
    }


    /**
     * Get the URL to check the payment status for a checkout.
     * 
     * @param string $url The URL of the checkout payment.
     *
     * @return string The URL to check the payment status.
     */
    public function getCheckoutPaymentStatusUrl($url)
    {
        $response =  $this->doGET($url, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Check if the is Payment Status Success request was successful.
     *
     * @param $code The API response code to check.
     * @return bool Whether the request was True|False.
     */
    public function isPaymentStatusSuccess($code)
    {
        return $code === CatalystPayResponseCode::CREATED_PAYMENT_STATUS;
    }

    /**
     * Check if the is Payment Transaction Pending request was true.
     *
     * @param $code The API response  code to check.
     * @return bool Whether the request was True|False.
     */
    public function isPaymentTransactionPending($code)
    {

        return $code === CatalystPayResponseCode::TRANSACTION_PENDING;
    }

    /**
     * Check if the is Payment request not found was true.
     *
     * @param $code The API response  code to check.
     * @return bool Whether the request was True|False.
     */
    public function isPaymentRequestNotFound($code)
    {

        return $code === CatalystPayResponseCode::REQUEST_NOT_FOUND;
    }

    /**
     * Check if the is Payment request was successful.
     *
     * @param $response The API response to check.
     * @return bool Whether the request was True|False.
     */
    public function isPaymentSuccessful($response)
    {
        $paymentCategories = $response->getResultCodeCategories($response->getResultCode());
        return in_array(CatalystPayResponse::RESULT_CODE_CAT_SUCCESS_PROCESS, $paymentCategories);
    }
}
