<?php

namespace Tests\CatalystPayTestCase;

use CatalystPay\CatalystPaySDK;
use Tests\TestCase;

class SettlementReportsTestCase extends TestCase
{
    /**
     * Test the get detail Level for a particular aggregation id.
     */
    public function testGetDetailLevelById()
    {
        $catalystPay =  $this->getCatalystPayConfig();
        $response = $catalystPay->getDetailLevelById(['id' => '8a82944a4cc25ebf014cc2c782423202', 'sortValue' => 'SettlementTxDate', 'sortOrder' => 'ASC', 'testMode' => CatalystPaySDK::TEST_MODE_INTERNAL]);

        // assert
        $this->assertTrue($response->isSuccessful(), 'The get detail Level by id returned ' . $response->getResultCode());
    }

    /**
     * Test the get summary level information for a certain date and/or settlement currency.
     */
    public function testGetSettlementReportBySummary()
    {
        $catalystPay =  $this->getCatalystPayConfig();
        $response = $catalystPay->getSettlementReportBySummary(['dateFrom' => '2015-08-01', 'dateTo' => '2015-08-02', 'currency' => 'EUR', 'testMode' => CatalystPaySDK::TEST_MODE_INTERNAL]);

        // assert
        $this->assertTrue($response->isSuccessful(), 'The get summary level information for a certain date and/or settlement currency' . $response->getResultCode());
    }

    /**
     * Test the get Detail Level with Pagination.
     */
    public function testGetDetailLevelByIdWithPagination()
    {
        $catalystPay =  $this->getCatalystPayConfig();
        $response = $catalystPay->getDetailLevelByIdWithPagination(['id' => '8a82944a4cc25ebf014cc2c782423202', 'reconciliationType' => 'SETTLED', 'testMode' => CatalystPaySDK::TEST_MODE_INTERNAL, "pageNo" => 2]);

        // assert
        $this->assertTrue($response->isSuccessful(), 'The get detail level pagination returned ' . $response->getResultCode());
    }
}
