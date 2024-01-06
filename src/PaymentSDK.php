<?php

namespace CatalystPay;

use CatalystPay\Traits\Client\PerformsGET;
use CatalystPay\Traits\Client\PerformsPOST;

/**
 * PaymentSDK class for handling payment operations.
 */
class PaymentSDK
{
    use PerformsGET, PerformsPOST;

    /** @var string The base URL for API requests. */
    private $baseUrl;

    /** @var string The API token for authentication. */
    private $token;

    /** @var string The entity ID for the payment. */
    private $entityId;

    /** @var string Comma-separated list of card brands to be displayed. */
    private $brands;

    /** @var bool The mode indicating whether to use SSL verification in requests. False when isDevelopment is false */
    private $isDevelopment = false;

    const URI_CHECKOUTS = 'v1/checkouts';
    const URI_PAYMENT_WIDGETS = '/v1/paymentWidgets.js';
    const URI_PAYMENT = '/payment';
    /**
     * Constructs a new PaymentSDK instance.
     *
     * @param string $baseUrl  The base URL for API requests.
     * @param string $token    The API token for authentication.
     * @param string $entityId The entity ID for the payment.
     * @param bool   $isDevelopment     The isDevelopment indicating whether to use SSL verification in requests.
     */
    public function __construct($baseUrl, $token, $entityId, $isDevelopment)
    {
        $this->baseUrl = $baseUrl;
        $this->token = $token;
        $this->entityId  = $entityId;
        $this->isDevelopment = $isDevelopment;
    }

    /**
     * Sends an HTTP request to the specified URL.
     *
     * @param string $url    The URL to send the request to.
     * @param string $method The HTTP method (GET or POST).
     * @param array  $data   The data to be sent with the request (for POST requests).
     *
     * @return array The decoded JSON response.
     *
     * @throws \Exception If an error occurs during the request.
     */
    private function sendRequest($url, $method = 'GET', $data = [])
    {
        // Perform a POST request if the method is POST, otherwise perform a GET request
        if ($method === 'POST') {
            return $this->doPOST($url, $data, $this->isDevelopment, $this->token);
        } else {
            return $this->doGET($url, $this->isDevelopment, $this->token);
        }
    }

    /**
     * Prepares a new checkout.
     *
     * @param float  $amount      The amount of the payment.
     * @param string $currency    The currency of the payment.
     * @param string $paymentType The type of payment (e.g., DB, CD).
     *
     * @return array The decoded JSON response.
     */
    public function prepareCheckout($amount, $currency, $paymentType)
    {
        // Construct the URL for the checkout request
        $url = $this->baseUrl . self::URI_CHECKOUTS;

        // Prepare the data for the request
        $data = [
            'entityId' => $this->entityId,
            'amount' => $amount,
            'currency' => $currency,
            'paymentType' => $paymentType
        ];

        // Send the request and return the response
        return $this->sendRequest($url, 'POST', $data);
    }

    /**
     * Creates a payment form.
     *
     * @param string $checkoutId      The ID of the checkout.
     * @param string $shopperResultUrl The URL where the shopper is redirected after payment.
     * @param array  $dataBrands      Optional. Array of card brands to be displayed.
     *
     * @return string The HTML for the payment form.
     */
    public function createPaymentForm($checkoutId, $shopperResultUrl, $dataBrands = [])
    {

        // If dataBrands is not empty, convert it to a comma-separated string/ If dataBrands is not empty, convert it to a comma-separated string
        if (!empty($dataBrands)) {

            $this->brands = implode(',', $dataBrands);
        }
        // Construct the payment form HTML
        return '<script src="' . $this->baseUrl . self::URI_PAYMENT_WIDGETS . '?checkoutId=' . $checkoutId . '"></script>
        <form action=' . $shopperResultUrl . ' class="paymentWidgets" data-brands="' . $this->brands . '"></form>';
    }

    /**
     * Retrieves the payment status for a checkout.
     *
     * @param string $checkoutId The ID of the checkout.
     *
     * @return array The decoded JSON response.
     */
    public function getPaymentStatus($checkoutId)
    {
        // Construct the URL for retrieving payment status
        $url = $this->baseUrl . self::URI_CHECKOUTS . '/' . $checkoutId .  self::URI_PAYMENT;
        $url .= '?entityId=' . $this->entityId;

        // Send the request and return the response
        return $this->sendRequest($url);
    }
}
