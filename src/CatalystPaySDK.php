<?php

namespace CatalystPay;

use CatalystPay\Traits\CopyAndPayCheckout;
use CatalystPay\Traits\CreateCopyAndPayForm;
use CatalystPay\Traits\CreateRegistrationTokenForm;
use CatalystPay\Traits\RegistrationTokens;

/**
 * CatalystPaySDK class for handling payment operations.
 */
class CatalystPaySDK
{
    use CopyAndPayCheckout, CreateCopyAndPayForm, RegistrationTokens, CreateRegistrationTokenForm;

    /** @var string The base URL for API requests. */
    private $baseUrl;

    /** @var string The API token for authentication. */
    private $token;

    /** @var string The entity ID for the payment. */
    private $entityId;

    /** @var string Comma-separated list of card brands to be displayed. */
    private $brands;

    /** @var bool The mode indicating whether to use SSL verification in requests. False when isProduction is false */
    private $isProduction = false;


    /** @var string The client for the payment. */
    protected $client;

    // Constants for various Url
    const URI_CHECKOUTS = '/v1/checkouts';
    const URI_PAYMENT_WIDGETS = '/v1/paymentWidgets.js';
    const URI_REGISTRATION = "/registration";
    const URI_REGISTRATIONS = "/v1/registrations";
    const URI_PAYMENT = '/payment';
    const URI_PAYMENTS = '/payments';
    const DEVELOPMENT_URL = "https://eu-test.oppwa.com";
    const PRODUCTION_URL = "https://eu-prod.oppwa.com";

    // Constants for various payment type
    const PAYMENT_TYPE_PREAUTH = 'PA';
    const PAYMENT_TYPE_DEBIT = 'DB';
    const PAYMENT_TYPE_CREDIT = 'CD';
    const PAYMENT_TYPE_CAPTURE = 'CP';
    const PAYMENT_TYPE_REFUND = 'RF';
    const PAYMENT_TYPE_REVERSE = 'RV';

    // Constants for various payment brand
    const PAYMENT_BRAND_VISA = 'VISA';
    const PAYMENT_BRAND_MASTERCARD = 'MASTER';
    const PAYMENT_BRAND_AMEX = 'AMEX';

    // Constants for various testMode
    const TEST_MODE_EXTERNAL = 'EXTERNAL';

    // Constants for various standing instruction
    const STANDING_INSTRUCTION_TYPE_UNSCHEDULED = 'UNSCHEDULED';
    const STANDING_INSTRUCTION_MODE_INITIAL = 'INITIAL';
    const STANDING_INSTRUCTION_SOURCE_CIT = 'CIT';

    /**
     * Constructs a new CatalystPaySDK instance.
     *
     * @param string $baseUrl  The base URL for API requests.
     * @param string $token    The API token for authentication.
     * @param string $entityId The entity ID for the payment.
     * @param bool   $isProduction     The isProduction indicating whether to use SSL verification in requests.
     */
    public function __construct($token, $entityId, $isProduction = false)
    {
        //Check if is DEVELOPMENT server
        if ($isProduction === false) {
            $this->baseUrl =  self::DEVELOPMENT_URL;
        } else {
            $this->baseUrl =  self::PRODUCTION_URL;
        }

        $this->token = $token;
        $this->entityId  = $entityId;
        $this->isProduction = $isProduction;
    }
}
