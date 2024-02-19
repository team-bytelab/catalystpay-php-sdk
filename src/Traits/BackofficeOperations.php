<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * Trait Backoffice Operations
 * This trait provides different types of backoffice operations using our server-to-server REST .
 */
trait BackofficeOperations
{
    use PerformsGET, PerformsPOST;

    /**
     * payments by operations .
     * 
     * @param array  $data The payment data like amount,  currency ,paymentType etc.
     * 
     * @return string $response.
     */
    public function paymentsByOperations($data = [])
    {
        $baseOptions = [];
        $baseOptions = [
            "entityId" => $this->entityId,
            "paymentType" => $data['paymentType'],
        ];

        //Check if payment type not reversal
        if ($data['paymentType'] !== 'RV') {
            $baseOptions["amount"] = $data['amount'];
            $baseOptions["currency"] = $data['currency'];
        }

        //print_r($baseOptions);
        $url = $this->baseUrl . CatalystPaySDK::URI_BACKOFFICE_OPERATIONS_PAYMENTS . '/' . $data['paymentId'];
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);

        return  $response;
    }

    /**
     * Credit is a independent transaction that results in a refund.
     * 
     * @param array  $data  The payment data like amount,currency,paymentBrand,paymentType etc.
     * 
     * @return string $response.
     */
    public function CreditStandAloneRefund($data = [])
    {
        $baseOptions = [];
        $baseOptions = [
            "entityId" => $this->entityId,
            "paymentType" => $data['paymentType'],
            "amount" => $data['amount'],
            "currency" => $data['currency'],
            "paymentBrand" => $data['paymentBrand'],
            "card.number" => $data['cardNumber'],
            "card.expiryMonth" => $data['cardExpiryMonth'],
            "card.expiryYear" => $data['cardExpiryYear'],
            "card.holder" => $data['cardHolder'],
        ];

        //print_r($baseOptions);
        $url = $this->baseUrl . CatalystPaySDK::URI_BACKOFFICE_OPERATIONS_PAYMENTS;
        $response =  $this->doPOST($url, $baseOptions, $this->isProduction, $this->token);
        return  $response;
    }
}
