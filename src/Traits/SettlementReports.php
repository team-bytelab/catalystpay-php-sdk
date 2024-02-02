<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;

/**
 * Trait SettlementReports
 * This trait provides settlement data from your connector (where supported), contributing to your reconciliation processes.
 */
trait SettlementReports
{
    use PerformsGET;

    /**
     * Get summary level information for a certain date and/or settlement currency .
     * 
     * @param array  $data  The settlement data like dateFrom, dateTo, currency ,testMode etc.
     * 
     * @return string $response.
     */
    public function getSettlementReportBySummary($data = [])
    {
        $query = '';

        // Check  specified time frame
        if (!empty($data['dateFrom']) && !empty($data['dateTo'])) {
            $query .= "date.from=" . urlencode($data['dateFrom']) . "&date.to=" . urlencode($data['dateTo']);
        }

        //Check currency
        if (!empty($data['currency'])) {
            $query .= "&currency=" . $data['currency'];
        }

        //Check testMode
        if (!empty($data['testMode'])) {
            $query .= "&testMode=" . $data['testMode'];
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_SETTLEMENT_REPORTS . '?' . $query . '&entityId=' . $this->entityId;

        $response = $this->doGET($url, $this->isProduction, $this->token);
        return  $response;
    }

    /**
     * Get detail Level for a particular aggregation id.
     * 
     * @param array  $data  The settlement data like id,testMode etc.
     * 
     * @return string $response.
     */
    public function getDetailLevelById($data = [])
    {
        $query = '';

        //Check testMode
        if (!empty($data['testMode'])) {
            $query .= "&testMode=" . $data['testMode'];
        }

        //Check sortValue
        if (!empty($data['sortValue'])) {
            $query .= "&sortValue=" . $data['sortValue'];
        }

        //Check sortOrder
        if (!empty($data['sortOrder'])) {
            $query .= "&sortOrder=" . $data['sortOrder'];
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_SETTLEMENT_REPORTS . '/' . $data['id'] . '?entityId=' . $this->entityId . $query;
        return $this->doGET($url, $this->isProduction, $this->token);
    }

    /**
     * Get Detail Level with Pagination .
     *
     *  @param array  $data  The settlement data like id,testMode , pageNo etc.
     * 
     * @return string $response.
     */
    public function getDetailLevelByIdWithPagination($data = [])
    {
        $query = '';

        //Check testMode
        if (!empty($data['testMode'])) {
            $query .= "&testMode=" . $data['testMode'];
        }

        //Check reconciliationType
        if (!empty($data['reconciliationType']) && $data['reconciliationType'] > 0) {
            $query .= "&reconciliationType=" . $data['reconciliationType'];
        }

        //Check pagination no
        if (!empty($data['pageNo']) && $data['pageNo'] > 0) {
            $query .= "&pageNo=" . $data['pageNo'];
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_SETTLEMENT_REPORTS_PAGINATION . '/' . $data['id'] . '?entityId=' . $this->entityId . $query;
        return $this->doGET($url, $this->isProduction, $this->token);
    }
}
