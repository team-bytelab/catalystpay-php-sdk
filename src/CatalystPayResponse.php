<?php

namespace CatalystPay;

use CatalystPay\Exceptions\CatalystPayException;
use CatalystPay\Traits\Response\ResultCode;

/**
 * Class CatalystPayResponse
 * Represents a response from the CatalystPay API.
 */
class CatalystPayResponse
{
    use ResultCode;
    // Constants for various result codes
    const RESULT_CODE_CAT_SUCCESS_PROCESS = "SUCCESS_PROCESS";
    const RESULT_CODE_CAT_SUCCESS_PROCESS_MANUAL_REVIEW = "SUCCESS_PROCESS_MANUAL_REVIEW";
    const RESULT_CODE_CAT_PENDING = "PENDING";
    const RESULT_CODE_CAT_PENDING_WAITING = "PENDING_WAITING";
    const RESULT_CODE_CAT_REJECTED_3DS_INTERBANK = "REJECTED_3DS_INTERBANK";
    const RESULT_CODE_CAT_REJECTED_EXTERNAL = "REJECTED_EXTERNAL";
    const RESULT_CODE_CAT_REJECTED_COMMS = "REJECTED_COMMS";
    const RESULT_CODE_CAT_REJECTED_SYS = "REJECTED_SYS";
    const RESULT_CODE_CAT_REJECTED_ASYNC = "REJECTED_ASYNC";
    const RESULT_CODE_CAT_REJECTED_RISK = "REJECTED_RISK";
    const RESULT_CODE_CAT_REJECTED_ADDRESS = "REJECTED_ADDRESS";
    const RESULT_CODE_CAT_REJECTED_3DS = "REJECTED_3DS";
    const RESULT_CODE_CAT_REJECTED_BLACKLIST = "REJECTED_BLACKLIST";
    const RESULT_CODE_CAT_REJECTED_RISK_VALIDATION = "REJECTED_RISK_VALIDATION";
    const RESULT_CODE_CAT_REJECTED_CONFIG = "REJECTED_CONFIG";
    const RESULT_CODE_CAT_REJECTED_REGISTRATION = "REJECTED_REGISTRATION";
    const RESULT_CODE_CAT_REJECTED_JOB = "REJECTED_JOB";
    const RESULT_CODE_CAT_REJECTED_REF = "REJECTED_REF";
    const RESULT_CODE_CAT_REJECTED_FORMAT = "REJECTED_FORMAT";
    const RESULT_CODE_CAT_REJECTED_ADDRESS_VALIDATION = "REJECTED_ADDRESS_VALIDATION";
    const RESULT_CODE_CAT_REJECTED_CONTACT = "REJECTED_CONTACT";
    const RESULT_CODE_CAT_REJECTED_ACCOUNT = "REJECTED_ACCOUNT";
    const RESULT_CODE_CAT_REJECTED_AMOUNT = "REJECTED_AMOUNT";
    const RESULT_CODE_CAT_REJECTED_RISK_MANAGEMENT = "REJECTED_RISK_MANAGMENT";
    const RESULT_CODE_CAT_CHARGEBACK = "CHARGEBACK";

    // Properties
    protected $json;
    protected $data;
    protected $apiResponse;

    /**
     * Set the JSON content of the response.
     *
     * @param string $json The JSON content.
     * @return CatalystPayResponse The current instance for method chaining.
     */
    public function setJson($json)
    {
        $this->json = $json;
        return $this;
    }

    /**
     * Get the JSON content of the response.
     *
     * @return string|null The JSON content, or null if not set.
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * Get the JSON content of the response.
     *
     * @return string|null The JSON content, or null if not set.
     */
    public function fromApiResponse($response)
    {
        $this->apiResponse = $response;

        if (!empty($response)) {
            $json = $response;
            return $this->setJson($json)->parseJson();
        } else {
            throw new CatalystPayException(
                'The request did not return JSON',
                $this->getResultCode()
            );
        }
    }

    /**
     * Get the JSON content of the response.
     *
     * @return string|null The JSON content, or null if not set.
     */
    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * Parses the JSON content of the response.
     *
     * @return CatalystPayResponse The current instance for method chaining.
     */
    public function parseJson()
    {
        $this->data = json_decode($this->json, true);
        return $this;
    }

    /**
     * Get the parsed data from the JSON response.
     *
     * @return array|null The parsed data, or null if parsing failed.
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * Get a specific data element from the parsed JSON response.
     *
     * @param string $key The key of the data element to retrieve.
     * @return mixed|null The value of the data element, or null if not found.
     */

    public function get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
    }

    /**
     * Get the result data from the parsed JSON response.
     *
     * @return array The result data array.
     */
    public function getResultData()
    {
        $result = $this->get('result');
        if ($result && is_array($result)) {
            return $result;
        }

        return [];
    }

    /**
     * Get the result code from the parsed JSON response.
     *
     * @return string|null The result code, or null if not found.
     */
    public function getResultCode()
    {
        $data = $this->getResultData();
        if (isset($data['code'])) {
            return $data['code'];
        }
    }

    /**
     * Get the result description from the parsed JSON response.
     *
     * @return string|null The result description, or null if not found.
     */
    public function getResultDescription()
    {
        $data = $this->getResultData();
        if (isset($data['description'])) {
            return $data['description'];
        }
    }

    /**
     * Get the ID from the parsed JSON response.
     *
     * @return mixed|null The ID, or null if not found.
     */
    public function getId()
    {
        return $this->get('id');
    }

    /**
     * Check if the is request was successful.
     *
     * @return bool Whether the request was True|False.
     */
    public function isSuccessful()
    {
        $categories = $this->getResultCodeCategories($this->getResultCode());
        return in_array(CatalystPayResponse::RESULT_CODE_CAT_SUCCESS_PROCESS, $categories);
    }

    /**
     * Check if the is Payment request not found was true.
     *
     * @return bool Whether the request was True|False.
     */
    public function isPaymentRequestNotFound()
    {
        return $this->getResultCode() === CatalystPayResponseCode::REQUEST_NOT_FOUND;
    }

    /**
     * Check if the is Status Success request was successful.
     *
     * @return bool Whether the request was True|False.
     */
    public function isPaymentStatus()
    {
        return $this->getResultCode()  === CatalystPayResponseCode::CREATED_PAYMENT;
    }

    /**
     * Check if the is Payment Transaction Pending request was true.
     *
     * @return bool Whether the request was True|False.
     */
    public function isPaymentTransactionPending()
    {

        return  $this->getResultCode() === CatalystPayResponseCode::TRANSACTION_PENDING;
    }

    /**
     * Check if the prepare Checkout request was successful.
     *
     * @return bool Whether the request was successful.
     */
    public function isCheckoutSuccess()
    {
        return $this->getResultCode() === CatalystPayResponseCode::CREATED_CHECKOUT;
    }

    /**
     * Check if the is Status Success request was successful.
     *
     * @return bool Whether the request was True|False.
     */
    public function isRegistrationStatus()
    {
        return $this->getResultCode()  === CatalystPayResponseCode::CREATED_REGISTRATION_TOKEN;
    }

    /**
     * Get the redirect from the parsed JSON response.
     *
     * @return mixed|null The redirect, or null if not found.
     */
    public function getRedirect()
    {
        return $this->get('redirect');
    }
}
