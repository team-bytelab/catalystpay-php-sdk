<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;

/**
 * Trait TransactionReports
 * This trait provides transaction reports allow to retrieve detailed transactional data from the platform.
 */
trait TransactionReports
{
    use PerformsGET;

    /**
     * Get transaction by id.
     *
     * @param string $id The ID of the payment 3D Secure.
     * @return string $response.
     */
    public function getTransactionById($data = [])
    {
        $query = '';
        //check if includeLinkedTransactions true
        if (isset($data['includeLinkedTransactions'])) {
            $query = "&includeLinkedTransactions=" . $data['includeLinkedTransactions'];
        }
        //check if payment type 
        if (isset($data['paymentTypes'])) {
            $query = "&paymentTypes=" . $data['paymentTypes'];
        }
        //check if payment type 
        if (isset($data['paymentMethods '])) {
            $query = "&paymentMethods =" . $data['paymentMethods'];
        }
        $url = $this->baseUrl . CatalystPaySDK::URI_TRANSACTION_REPORTS . '/' . $data['id'] . '?entityId=' . $this->entityId . $query;
        return $this->doGET($url, $this->isProduction, $this->token);
    }

    /**
     * Get merchant transaction using id reference.
     *
     * @param string $merchantTransactionId The ID of the merchant transaction. 
     * 
     * @return string $response.
     */
    public function getMerchantTransactionById($merchantTransactionId = '')
    {
        $query = '';

        // Check merchant transaction id
        if (!empty($merchantTransactionId)) {
            $query = "merchantTransactionId=" . $merchantTransactionId;
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_TRANSACTION_REPORTS . '?' . $query . '&entityId=' . $this->entityId;
        return $this->doGET($url, $this->isProduction, $this->token);
    }

    /**
     * Get transactions for a specified time frame.
     *
     * @param array  $data  The transaction data like dateFrom, dateTo, limit etc.
     * 
     * @return string $response.
     */
    public function getTransactionByDateFilter($data = [])
    {
        $query = '';

        // Check  specified time frame
        if (!empty($data['dateFrom']) && !empty($data['dateTo'])) {
            $query .= "date.from=" . urlencode($data['dateFrom']) . "&date.to=" . urlencode($data['dateTo']);
        }
        // Check merchant transaction id
        if (!empty($merchantTransactionId)) {
            $query = "merchantTransactionId=" . $merchantTransactionId;
        }

        //check if payment type 
        if (isset($data['paymentTypes'])) {
            $query = "&paymentTypes=" . $data['paymentTypes'];
        }
        //check if payment type 
        if (isset($data['paymentMethods '])) {
            $query = "&paymentMethods =" . $data['paymentMethods'];
        }

        //Check limit
        if (!empty($data['limit']) && $data['limit'] > 0) {
            $query .= "&limit=" . $data['limit'];
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_TRANSACTION_REPORTS . '?' . $query . '&entityId=' . $this->entityId;
        return $this->doGET($url, $this->isProduction, $this->token);
    }

    /**
     * Get transactions for a specified time frame with pagination.
     *
     *@param array  $data  The transaction data like dateFrom, dateTo, pageNo etc.

     * @return string $response.
     */
    public function getTransactionByDateWithPagination($data = [])
    {
        $query = '';

        // Check  specified time frame
        if (!empty($data['dateFrom']) && !empty($data['dateTo'])) {
            $query .= "date.from=" . urlencode($data['dateFrom']) . "&date.to=" . urlencode($data['dateTo']);
        }

        // Check merchant transaction id
        if (!empty($merchantTransactionId)) {
            $query = "merchantTransactionId=" . $merchantTransactionId;
        }

        //check if payment type 
        if (isset($data['paymentTypes'])) {
            $query = "&paymentTypes=" . $data['paymentTypes'];
        }
        //check if payment type 
        if (isset($data['paymentMethods '])) {
            $query = "&paymentMethods =" . $data['paymentMethods'];
        }

        //Check limit
        if (!empty($data['limit']) && $data['limit'] > 0) {
            $query .= "&limit=" . $data['limit'];
        }

        //Check pagination no
        if (!empty($data['pageNo']) && $data['pageNo'] > 0) {
            $query .= "&pageNo=" . $data['pageNo'];
        }
        $url = $this->baseUrl . CatalystPaySDK::URI_TRANSACTION_REPORTS . '?' . $query . '&entityId=' . $this->entityId;
        return $this->doGET($url, $this->isProduction, $this->token);
    }
}
