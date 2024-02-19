<?php

namespace CatalystPay\Traits;

use CatalystPay\CatalystPaySDK;
use CatalystPay\Traits\Client\PerformsGET;

/**
 * Trait CreateRegistrationTokenForm
 * This trait provides methods to interact with the CatalystPay Registration Token Form API.
 */
trait CreateRegistrationTokenForm
{
    use PerformsGET;

    /**
     * Create a registration payment form HTML with Registration Form script.
     *
     * @param array array  $data  The payment data like checkoutId,shopperResultUrl , dataBrands ,wpwlOptions.
     * 
     * @return string The HTML form with payment widgets.
     */
    public function getCreateRegistrationPaymentForm($data = [])
    {
        $wpwlOptions = $data['wpwlOptions'] ?? "";
        return $this->getCreateRegistrationFormScript($data['checkoutId'], $wpwlOptions) . $this->getRegistrationPaymentForm($data['shopperResultUrl'], $data['dataBrands']);
    }

    /**
     * Get the payment form HTML with specified shopper result URL and data brands.
     *
     * @param string $shopperResultUrl The URL to redirect the shopper after payment.
     * @param array $dataBrands The payment brands to display (optional).
     * @return string The HTML form with payment widgets.
     */
    public function getRegistrationPaymentForm($shopperResultUrl = '', $dataBrands = [CatalystPaySDK::PAYMENT_BRAND_VISA, CatalystPaySDK::PAYMENT_BRAND_MASTERCARD, CatalystPaySDK::PAYMENT_BRAND_AMEX])
    {
        // If dataBrands is not empty, convert it to a comma-separated string/ If dataBrands is not empty, convert it to a comma-separated string
        if (!empty($dataBrands)) {

            $this->brands = implode(' ', $dataBrands);
        }
        return '<form action=' . $shopperResultUrl . ' class="paymentWidgets" data-brands="' . $this->brands . '"></form>';
    }

    /**
     * Get the Registration Form script HTML with the specified checkout ID.
     *
     * @param string $checkoutId The ID of the checkout.
     * @param string $wpwlOptions The payment form can be changed by setting.
     * 
     * @return string The HTML script tag for the Registration Form script.
     */
    public function getCreateRegistrationFormScript($checkoutId, $wpwlOptions = '')
    {
        $html = '';
        if ($wpwlOptions) {
            $html .= '<script>var wpwlOptions = ' . $wpwlOptions . ' </script>';
        }
        $html .= '<script src='
            . '"' . $this->getCopyAndPayScriptUrl($checkoutId) . '"'
            . '></script>';
        return $html;
    }

    /**
     * Get the URL for the Registration Form script with the specified checkout ID.
     *
     * @param string $checkoutId The ID of the checkout.
     * @return string The URL for the Registration Form script.
     */
    public function getCreateRegistrationFormScriptUrl($checkoutId)
    {
        return $this->baseUrl . CatalystPaySDK::URI_PAYMENT_WIDGETS
            . '?checkoutId=' . $checkoutId . CatalystPaySDK::URI_REGISTRATION;
    }
}
