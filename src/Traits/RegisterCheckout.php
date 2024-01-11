<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Exceptions\CatalystPayException;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * Trait RegisterCheckout
 * This trait provides methods to interact with the CatalystPay Register checkout API.
 */
trait RegisterCheckout
{
    use PerformsPOST;

    /**
     * Prepares a new Register Payment checkout.
     *
     * @param string  $testMode The testMode to check the payment mode.     
     * @param bool $createRegistration    The createRegistration of the payment.
     *
     * @return array The decoded JSON response.
     */
    public function registerPaymentCheckout($paymentBrand, $paymentType, $amount, $currency, $standingInstructionType, $standingInstructionMode, $standingInstructionSource, $testMode)
    {
        $responseRegisterCheckout = $this->prepareRegisterCheckout($testMode);

        $checkoutId = $responseRegisterCheckout->getId();
        $isPrepareCheckoutSuccess = $this->isPrepareCheckoutSuccess($responseRegisterCheckout->getResultCode());
        if (!$isPrepareCheckoutSuccess) {
            throw new CatalystPayException(
                'The Prepare Checkout was not successful',
                $responseRegisterCheckout->getResultCode()

            );
        }
        $data = [
            'checkoutId' => $checkoutId,
            'paymentBrand' => $paymentBrand,
            'paymentType' => $paymentType,
            'amount' => $amount,
            'currency' => $currency,
            'standingInstructionType' => $standingInstructionType,
            'standingInstructionMode' => $standingInstructionMode,
            'standingInstructionSource' => $standingInstructionSource,
            'testMode' => $testMode
        ];
        $responsePayment = $this->sendRegisterPayment($checkoutId, $data);
        return $responsePayment;
    }

    /**
     * Prepares a new Register checkout.
     *
     * @param string  $testMode The testMode to check the payment mode.     
     * @param bool $createRegistration    The createRegistration of the payment.
     *
     * @return array The decoded JSON response.
     */
    public function prepareRegisterCheckout($testMode)
    {
        // Form Data
        $baseOptions = "entityId=" . $this->entityId .
            "&testMode=" . $testMode .
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
    public function sendRegisterPayment($checkoutId, $data = [])
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


        $url = $this->getRegisterPaymentUrl($checkoutId);
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return $response;
    }

    /**
     * Get the URL for the Register Payment with the specified checkout ID.
     *
     * @param string $checkoutId The ID of the checkout.
     * @return string The URL for the Register Payment.
     */
    public function getRegisterPaymentUrl($checkoutId)
    {
        return $this->baseUrl . CatalystPaySDK::URI_REGISTRATIONS . '/' . $checkoutId . CatalystPaySDK::URI_PAYMENTS;
    }
}
