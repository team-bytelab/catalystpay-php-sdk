<?php

namespace CatalystPay\Traits\Response;

/**
 * A trait for interpreting result codes and categories.
 *
 * This trait provides methods for looking up result codes, initializing result code data,
 * and getting result code categories based on predefined patterns. It is used to interpret
 * the result codes received from the CatalystPay API responses.
 */
trait ResultCode
{
    /**
     * Looks up a result code and returns its description.
     *
     * @param string $code The result code to look up.
     * @return string|null The description of the result code, or null if not found.
     */
    public static function lookupResultCode($code)
    {
        static $data;
        if (!$data) {
            $data = self::initializeResultCodes();
        }

        if (isset($data[$code])) {
            return $data[$code];
        }
    }

    /**
     * Initializes the result code data from a JSON file.
     *
     * @return array An array of result codes and their descriptions.
     */
    public static function initializeResultCodes()
    {
        $returnData = [];

        $file = __DIR__
            . DIRECTORY_SEPARATOR
            . ".."
            . DIRECTORY_SEPARATOR
            . ".."
            . DIRECTORY_SEPARATOR
            . ".."
            . DIRECTORY_SEPARATOR
            . "data/resultcodes.json";

        $data = json_decode(file_get_contents($file), true);

        foreach ($data['resultCodes'] as $resultCode) {
            $returnData[$resultCode['code']] = $resultCode['description'];
        }

        return $returnData;
    }

    /**
     * Gets the categories of a result code based on predefined patterns.
     *
     * @param string $code The result code to get categories for.
     * @return array An array of categories that the result code belongs to.
     */
    public static function getResultCodeCategories($code)
    {
        $matches = [];
        $codeCategorisers = self::getCodeCategorisers();
        foreach ($codeCategorisers as $category => $pattern) {
            if (preg_match($pattern, $code)) {
                if (!in_array($category, $matches)) {
                    $matches[] = $category;
                }
            }
        }

        return $matches;
    }

    /**
     * Gets the categories of a result code based on predefined patterns.
     *
     * @param string $code The result code to get categories for.
     * @return array An array of categories that the result code belongs to.
     */
    public static function getCodeCategorisers()
    {
        $codeCategorisers = [];

        $codeCategorisers = [
            self::RESULT_CODE_CAT_SUCCESS_PROCESS => '/^(000\.000\.|000\.100\.1|000\.[356]|000\.100\.112)/',
            self::RESULT_CODE_CAT_SUCCESS_PROCESS_MANUAL_REVIEW => '/^(000\.400\.0[^3]|000\.400\.100)/',
            self::RESULT_CODE_CAT_PENDING => '/^(000\.200)/',
            self::RESULT_CODE_CAT_PENDING_WAITING => '/^(800\.400\.5|100\.400\.500)/',
            self::RESULT_CODE_CAT_REJECTED_3DS_INTERBANK => '/^(000\.400\.[1][0-9][1-9]|000\.400\.2)/',
            self::RESULT_CODE_CAT_REJECTED_EXTERNAL => '/^(800\.[167]00|800\.800\.[123])/',
            self::RESULT_CODE_CAT_REJECTED_COMMS => '/^(900\.[1234]00|000\.400\.030)/',
            self::RESULT_CODE_CAT_REJECTED_SYS => '/^(800\.5|999\.|600\.1|800\.800\.8)/',
            self::RESULT_CODE_CAT_REJECTED_ASYNC => '/^(100\.39[765])/',
            self::RESULT_CODE_CAT_REJECTED_RISK => ' /^(100\.400|100\.38|100\.370\.100|100\.370\.11)/',
            self::RESULT_CODE_CAT_REJECTED_ADDRESS => '/^(800\.400\.1)/',
            self::RESULT_CODE_CAT_REJECTED_3DS => '/^(800\.400\.2|100\.380\.4|100\.390)/',
            self::RESULT_CODE_CAT_REJECTED_BLACKLIST => '/^(100\.100\.701|800\.[32])/',
            self::RESULT_CODE_CAT_REJECTED_RISK_VALIDATION => '/^(800\.1[123456]0)/',
            self::RESULT_CODE_CAT_REJECTED_CONFIG => '/^(600\.[23]|500\.[12]|800\.121)/',
            self::RESULT_CODE_CAT_REJECTED_REGISTRATION => '/^(100\.[13]50)/',
            self::RESULT_CODE_CAT_REJECTED_JOB => '/^(100\.250|100\.360)/',
            self::RESULT_CODE_CAT_REJECTED_REF => '/^(700\.[1345][05]0)/',
            self::RESULT_CODE_CAT_REJECTED_FORMAT => '/^(200\.[123]|100\.[53][07]|800\.900|100\.[69]00\.500)/',
            self::RESULT_CODE_CAT_REJECTED_ADDRESS_VALIDATION => '/^(100\.800)/',
            self::RESULT_CODE_CAT_REJECTED_CONTACT => '/^(100\.[97]00)/',
            self::RESULT_CODE_CAT_REJECTED_ACCOUNT => '/^(100\.100|100.2[01])/',
            self::RESULT_CODE_CAT_REJECTED_AMOUNT => '/^(100\.55)/',
            self::RESULT_CODE_CAT_REJECTED_RISK_MANAGEMENT => '/^(100\.380\.[23]|100\.380\.101)/',
            self::RESULT_CODE_CAT_CHARGEBACK => '/^(000\.100\.2)/'
        ];

        return $codeCategorisers;
    }
}
