<?php

namespace Tests\CatalystPayTestCase;

use Tests\TestCase;

class TransactionReportsTestCase extends TestCase
{
    /**
     * Test the get transaction by id.
     */
    public function testGetTransactionById()
    {
        $catalystPay =  $this->getCatalystPayConfig();
        $response = $catalystPay->getTransactionById('8ac7a4a1845f7e19018461a00b366a74', 'true', 'DB,3D');

        // assert
        $this->assertTrue($response->isSuccessful(), 'The get transaction by id returned ' . $response->getResultCode());
    }

    /**
     * Test the get Transaction by merchant ID.
     */
    public function testGetMerchantTransactionById()
    {
        $catalystPay =  $this->getCatalystPayConfig();
        $transactionMerchant = $catalystPay->getMerchantTransactionById('test123');

        // assert
        $this->assertTrue($transactionMerchant->isSuccessful(), 'The get transaction by merchant ID  returned ' . $transactionMerchant->getResultCode());
    }
    /**
     * Test the get transactions for a specified time frame.
     */
    public function getTransactionByDateFilter()
    {
        $catalystPay =  $this->getCatalystPayConfig();
        $transactionSpecifiedTimeFrame = $catalystPay->getTransactionByDateFilter('2023-01-01 00:00:00', '2023-01-01 01:00:00', 20);

        // assert
        $this->assertTrue($transactionSpecifiedTimeFrame->isSuccessful(), 'The get transactions for a specified time frame returned ' . $transactionPagination->getResultCode());
    }
    /**
     * Test the get transactions for a specified time frame with pagination.
     */
    public function testGeTransactionByDateWithPagination()
    {
        $catalystPay =  $this->getCatalystPayConfig();
        $transactionPagination = $catalystPay->getTransactionByDateWithPagination('2023-01-01 00:00:00', '2023-01-01 01:00:00', 2);

        // assert
        $this->assertTrue($transactionPagination->isSuccessful(), 'The get transactions pagination returned ' . $transactionPagination->getResultCode());
    }
}
