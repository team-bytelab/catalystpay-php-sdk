<?php

namespace Tests\CatalystPayIntegration;

use Tests\TestCase;
use CatalystPay\CatalystPaySDK;
use CatalystPay\CatalystPayResponseCode;

class CopyAndPayCheckoutTest extends TestCase
{
    /**
     * Test the prepares a new checkout.
     */
    public function testPrepareCheckout()
    {
        $catalystPay = $this->getCatalystPayConfig();

        // Checkout Values defined variable
        $amount = 92.00;
        $currency = 'EUR';
        $paymentType = CatalystPaySDK::PAYMENT_TYPE_DEBIT;

        $response = $catalystPay->prepareCheckout($amount, $currency, $paymentType);

        // assert
        $this->assertTrue($response->isCheckoutSuccess(), 'The checkout returned ' . $response->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT);
        $this->assertGreaterThanOrEqual(1, strlen($response->getId()));
    }

    /**
     * Test the get the payment status for a checkout.
     */
    public function testGetPaymentStatus()
    {
        $catalystPay = $this->getCatalystPayConfig();

        // Checkout Values defined variable
        $amount = 92.00;
        $currency = 'EUR';
        $paymentType = CatalystPaySDK::PAYMENT_TYPE_DEBIT;

        $response = $catalystPay->prepareCheckout($amount, $currency, $paymentType);

        // assert
        $this->assertTrue($response->isCheckoutSuccess(), 'The checkout returned ' . $response->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT);
        $this->assertGreaterThanOrEqual(1, strlen($response->getId()));

        // Get the payment status
        $paymentStatusResponse = $catalystPay->getPaymentStatus($response->getId());
        $this->assertEquals(CatalystPayResponseCode::TRANSACTION_PENDING, $paymentStatusResponse->getResultCode(), 'The transaction should be pending, but is ' . $paymentStatusResponse->getResultCode());
    }
}
