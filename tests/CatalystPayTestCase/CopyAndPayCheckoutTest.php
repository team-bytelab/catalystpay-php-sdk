<?php

namespace Tests\CatalystPayTestCase;

use CatalystPay\CatalystPayResponse;
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
        $data = [
            'amount' => 92.00,
            'currency' => 'EUR',
            'paymentType' => CatalystPaySDK::PAYMENT_TYPE_DEBIT,
            'billing.city' => 'surat',
            'billing.country' => 'DE',
            'billing.street1' => 'test',
            'billing.postcode' => 394210,
            'customer.email' => 'test@gmail.com',
            'customer.givenName' => 'John Smith',
            'customer.surname' => 'Don',
            'customer.ip' => '192.168.0.1'
        ];

        $response = $catalystPay->prepareCheckout($data);

        // assert
        $this->assertTrue($response->isCheckoutSuccess(), 'The checkout returned ' . $response->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT);
        $this->assertGreaterThanOrEqual(1, strlen($response->getId()));

        //card details
        $cardData = [
            'amount' => 92.00,
            'currency' => 'EUR',
            'paymentBrand' => CatalystPaySDK::PAYMENT_BRAND_VISA,
            'paymentType' => CatalystPaySDK::PAYMENT_TYPE_DEBIT,
            'card.number' => 4111111111111111,
            'card.expiryMonth' => 12,
            'card.expiryYear' => 2025,
            'card.holder' => 'John Smith',
            'card.cvv' => 123,
        ];

        //payment with card
        $payCardRequest = $catalystPay->payCard($cardData);
        $this->assertTrue($payCardRequest->isSuccessful(), 'The payment was not successful and should have been');

        // Get the payment status
        $paymentStatusResponse = $catalystPay->getPaymentStatus($response->getId());
        $this->assertEquals(CatalystPayResponseCode::TRANSACTION_PENDING, $paymentStatusResponse->getResultCode(), 'The transaction should be pending, but is ' . $paymentStatusResponse->getResultCode());
    }
}
