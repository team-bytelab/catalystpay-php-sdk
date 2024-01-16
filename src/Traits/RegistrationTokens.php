<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * Trait RegistrationTokens
 * This trait provides methods to interact with the CatalystPay COPYandPAY Registration Tokens API.
 */
trait RegistrationTokens
{
    use PerformsPOST, PerformsGET;

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
        $baseOptions = [
            "entityId" => $this->entityId,
            "testMode" => $data['testMode'],
            "createRegistration" => $data['createRegistration'],
        ];
        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Get the registration status.
     *
     * @param string $checkoutId The ID of the payment.
     * @return string The URL to check the payment status.
     */
    public function getRegistrationStatus($checkoutId)
    {
        $url = $this->baseUrl . CatalystPaySDK::URI_CHECKOUTS . '/' . $checkoutId . CatalystPaySDK::URI_REGISTRATION . '?entityId=' . $this->entityId;
        $response =  $this->doGET($url, $this->isProduction, $this->token);
        return $response;
    }

    /**
     *  Send payment using the token.
     *     
     * @param array $data The payment data like amount,currency paymentType etc.
     *
     * @return array The decoded JSON response.
     */
    public function sendRegistrationTokenPayment($paymentId, $data = [])
    {
        // Form Data
        $baseOptions = [
            "entityId" => $this->entityId,
            "paymentBrand" => $data['paymentBrand'],
            "paymentType" => $data['paymentType'],
            "amount" => $data['amount'],
            "currency" => $data['currency'],
            "standingInstruction.type" => $data['standingInstructionType'],
            "standingInstruction.mode" => $data['standingInstructionMode'],
            "standingInstruction.source" => $data['standingInstructionSource'],
            "testMode" => $data['testMode']
        ];

        $url = $this->baseUrl . CatalystPaySDK::URI_REGISTRATIONS . '/' . $paymentId . CatalystPaySDK::URI_PAYMENTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }
}
