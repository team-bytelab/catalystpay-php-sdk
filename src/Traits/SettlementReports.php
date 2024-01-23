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
     * @param string $dateFrom The dateFrom of the settlement report.
     * @param string $dateTo The dateTo of the settlement report.
     * @param string $currency The currency of the settlement report.
     * @param string $testMode The testMode of the settlement report.
     * 
     * @return string $response.
     */
    public function getSettlementReportBySummary($dateFrom = '', $dateTo = '',  $currency = 'EUR', $testMode = '')
    {
        $query = '';

        // Check  specified time frame
        if (!empty($dateFrom) && !empty($dateTo)) {
            $query .= "&date.from=" . $dateFrom . "&date.to=" . $dateTo;
        }

        //Check currency
        if (!empty($currency)) {
            $query .= "&currency=" . $currency;
        }

        //Check testMode
        if (!empty($testMode)) {
            $query .= "&testMode=" . $testMode;
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_SETTLEMENT_REPORTS . '?' . $query . '&entityId=' . $this->entityId;

        $response = $this->doGET($url, $this->isProduction, $this->token);
        return  $response;
    }

    /**
     * Get further details for a particular aggregation id .
     *
     * @param string $id The ID of the settlement report.
     * @param string $testMode The testMode of the settlement report .
     * 
     * @return string $response.
     */
    public function getDetailLevelById($id, $testMode = '')
    {
        $query = '';

        //Check testMode
        if (!empty($testMode)) {
            $query .= "&testMode=" . $testMode;
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_SETTLEMENT_REPORTS . '/' . $id . '?entityId=' . $this->entityId . $query;
        return $this->doGET($url, $this->isProduction, $this->token);
    }

    /**
     * Get further details for a particular aggregation id with pagination .
     *
     * @param string $id The ID of the settlement report.
     * @param string $testMode The testMode of the settlement report .
     * @param int $pageNo The pageNo of the settlement report.
     * 
     * @return string $response.
     */
    public function getDetailLevelByIdWithPagination($id, $testMode = '', $pageNo = 0)
    {
        $query = '';

        //Check testMode
        if (!empty($testMode)) {
            $query .= "&testMode=" . $testMode;
        }
        //Check pagination no
        if (!empty($pageNo) && $pageNo > 0) {
            $query .= "&pageNo=" . $pageNo;
        }

        $url = $this->baseUrl . CatalystPaySDK::URI_SETTLEMENT_REPORTS_PAGINATION . '/' . $id . '?entityId=' . $this->entityId . $query;
        return $this->doGET($url, $this->isProduction, $this->token);
    }
}
