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
    public function getTransactionById($id, $includeLinkedTransactions = false, $paymentTypes = '')
    {
        $query = '';
        if ($includeLinkedTransactions) {
            $query = "&includeLinkedTransactions=" . $includeLinkedTransactions;
        }
        if (!empty($paymentTypes)) {
            $query = "&paymentTypes=" . $paymentTypes;
        }
        $url = $this->baseUrl . CatalystPaySDK::URI_TRANSACTION_REPORTS . '/' . $id . '?entityId=' . $this->entityId . $query;
        return $this->doGET($url, $this->isProduction, $this->token);
    }

    /**
     * Get transaction using your filter reference.
     *
     * @param string $merchantTransactionId The ID of the merchant transaction.
     * @param string $dateFrom The dateFrom of the merchant transaction.
     * @param string $dateTo The dateTo of the merchant transaction.
     * @param int $limit The limit of the merchant transaction.
     * @param int $pageNo The pageNo of the merchant transaction.
     * 
     * @return string $response.
     */
    public function getTransactionByFilter($merchantTransactionId = '', $dateFrom = '', $dateTo = '', $limit = 0, $pageNo = 0)
    {
        $query = '';

        // Check merchant transaction id
        if (!empty($merchantTransactionId)) {
            $query = "&merchantTransactionId=" . $merchantTransactionId;
        }

        // Check  specified time frame
        if (!empty($dateFrom) && !empty($dateTo)) {
            $query .= "&date.from=" . $dateFrom . "&date.to=" . $dateTo;
        }

        //Check limit
        if (!empty($limit) && $limit > 0) {
            $query .= "&limit=" . $limit;
        }

        //Check pagination no
        if (!empty($pageNo) && $pageNo > 0) {
            $query = "&pageNo=" . $pageNo;
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_TRANSACTION_REPORTS . '?' . $query . '&entityId=' . $this->entityId;
        return $this->doGET($url, $this->isProduction, $this->token);
    }
}
