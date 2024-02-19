<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;

/**
 * Trait CreateCopyAndPayForm
 * This trait provides methods to interact with the CatalystPay Create the payment form COPYandPAY  API.
 */
trait CreateCopyAndPayForm
{
    use PerformsGET;

    /**
     * Create a payment form HTML with Copy and Pay script.
     *
     * @param array array  $data  The payment data like checkoutId,shopperResultUrl , dataBrands ,wpwlOptions.
     * 
     * @return string The HTML form with payment widgets.
     */
    public function createPaymentForm($data = [])
    {
        $wpwlOptions = $data['wpwlOptions'] ?? "";
        return $this->getCopyAndPayScript($data['checkoutId'], $wpwlOptions) . $this->getPaymentForm($data['shopperResultUrl'], $data['dataBrands']);
    }

    /**
     * Get the payment form HTML with specified shopper result URL and data brands.
     *
     * @param string $shopperResultUrl The URL to redirect the shopper after payment.
     * @param array $dataBrands The payment brands to display (optional).
     * @return string The HTML form with payment widgets.
     */
    public function getPaymentForm($shopperResultUrl = '', $dataBrands = [CatalystPaySDK::PAYMENT_BRAND_VISA, CatalystPaySDK::PAYMENT_BRAND_MASTERCARD, CatalystPaySDK::PAYMENT_BRAND_AMEX])
    {
        // If dataBrands is not empty, convert it to a comma-separated string/ If dataBrands is not empty, convert it to a comma-separated string
        if (!empty($dataBrands)) {

            $this->brands = implode(' ', $dataBrands);
        }

        return '<form action=' . $shopperResultUrl . ' class="paymentWidgets" data-brands="' . $this->brands . '"></form>';
    }

    /**
     * Get the Copy and Pay script HTML with the specified checkout ID.
     *
     * @param string $checkoutId The ID of the checkout.
     * @param string $wpwlOptions The payment form can be changed by setting.
     * 
     * @return string The HTML script tag for the Copy and Pay script.
     */
    public function getCopyAndPayScript($checkoutId, $wpwlOptions = '')
    {
        $html = '';
        if ($wpwlOptions) {
            $html .= '<script>var wpwlOptions =' . $wpwlOptions . ' </script>';
        }
        $html .= '<script src='
            . '"' . $this->getCopyAndPayScriptUrl($checkoutId) . '"'
            . '></script>';
        return $html;
    }

    /**
     * Get the URL for the Copy and Pay script with the specified checkout ID.
     *
     * @param string $checkoutId The ID of the checkout.
     * @return string The URL for the Copy and Pay script.
     */
    public function getCopyAndPayScriptUrl($checkoutId)
    {
        return $this->baseUrl . CatalystPaySDK::URI_PAYMENT_WIDGETS
            . '?checkoutId=' . $checkoutId;
    }
}
