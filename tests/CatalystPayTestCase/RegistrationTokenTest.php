<?php

namespace Tests\CatalystPayTestCase;

use CatalystPay\CatalystPayResponse;
use Tests\TestCase;
use CatalystPay\CatalystPaySDK;
use CatalystPay\CatalystPayResponseCode;

class RegistrationTokenTest extends TestCase
{
    /**
     * Test the prepares a new checkout.
     */
    public function testPrepareRegistrationTokenCheckout()
    {

        $catalystPay =  $this->getCatalystPayConfig();

        // Form Values defined variable
        $data = [
            'testMode' => CatalystPaySDK::TEST_MODE_EXTERNAL,
            'createRegistration' => true
        ];
        //Prepare Check out form 
        $response = $catalystPay->prepareRegisterCheckout($data);

        // assert
        $this->assertTrue($response->isCheckoutSuccess(), 'The checkout returned ' . $response->getResultCode() . ' instead of ' . CatalystPayResponseCode::CREATED_CHECKOUT);
        $this->assertGreaterThanOrEqual(1, strlen($response->getId()));

        // Get the Registration Token status
        $registrationTokenStatusResponse = $catalystPay->getRegistrationStatus($response->getId());
        $this->assertEquals(!$registrationTokenStatusResponse->isRegistrationStatus(), $registrationTokenStatusResponse->getResultCode(), 'The transaction should be pending, but is ' . $registrationTokenStatusResponse->getResultCode());    // Send payment using the token


        // Registration Token Values defined variable
        $data = [
            'paymentBrand' => CatalystPaySDK::PAYMENT_BRAND_VISA,
            'paymentType' =>  CatalystPaySDK::PAYMENT_TYPE_DEBIT,
            'amount' => 92.00,
            'currency' => 'EUR',
            'standingInstructionType' =>  CatalystPaySDK::STANDING_INSTRUCTION_TYPE_UNSCHEDULED,
            'standingInstructionMode' =>  CatalystPaySDK::STANDING_INSTRUCTION_MODE_INITIAL,
            'standingInstructionSource' => CatalystPaySDK::STANDING_INSTRUCTION_SOURCE_CIT,
            'testMode' => CatalystPaySDK::TEST_MODE_EXTERNAL
        ];
        $registerPayment = $catalystPay->sendRegistrationTokenPayment($registrationTokenStatusResponse->getId(), $data);
        $this->assertTrue($registerPayment->isPaymentTransactionPending(), 'The payment' . $registerPayment->getId() . ' was not successful and should have been');
    }
}
