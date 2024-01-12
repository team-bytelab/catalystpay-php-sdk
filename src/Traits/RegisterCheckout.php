<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * Trait RegisterCheckout
 * This trait provides methods to interact with the CatalystPay Register checkout API.
 */
trait RegisterCheckout
{
    use PerformsPOST;

    /**
     * Prepares a new Register checkout.
     *
     * @param array  $data  The payment data like amount,currency paymentType etc..     
     *
     * @return array The decoded JSON response.
     */
    public function prepareRegisterCheckout($data)
    {
        // Form Data
        $baseOptions = "entityId=" . $this->entityId .
            "&testMode=" . $data['testMode'] .
            "&createRegistration=" .  $this->isCreateRegistration;
        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Send a new Register Payment.
     *     
     * @param array $data The payment data like amount,currency paymentType etc.
     *
     * @return array The decoded JSON response.
     */
    public function sendRegisterPayment($paymentId, $data = [])
    {
        // Form Data
        $baseOptions = "entityId=" . $this->entityId .
            "&paymentBrand=" . $data['paymentBrand'] .
            "&paymentType=" . $data['paymentType'] .
            "&amount=" . $data['amount'] .
            "&currency=" . $data['currency'] .
            "&standingInstruction.type=" . $data['standingInstructionType'] .
            "&standingInstruction.mode=" . $data['standingInstructionMode'] .
            "&standingInstruction.source=" . $data['standingInstructionSource'] .
            "&testMode=" . $data['testMode'];


        $url = $this->getRegisterPaymentUrl($paymentId);
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Get the URL for the Register Payment with the specified paymentId.
     *
     * @param string $paymentId The ID of the checkout.
     * @return string The URL for the Register Payment.
     */
    public function getRegisterPaymentUrl($paymentId)
    {
        return $this->baseUrl . CatalystPaySDK::URI_REGISTRATIONS . '/' . $paymentId . CatalystPaySDK::URI_PAYMENTS;
    }
}
