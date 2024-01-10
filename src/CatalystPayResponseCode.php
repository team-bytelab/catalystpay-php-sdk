<?php

namespace CatalystPay;

/**
 * Class CatalystPayResponseCode
 * Contains constants representing response codes from the CatalystPay API.
 */
class CatalystPayResponseCode
{
    /**
     * The response code for a created checkout.
     */
    const CREATED_CHECKOUT = '000.200.100';

    /**
     * The response code for a pending transaction.
     */
    const TRANSACTION_PENDING = '000.200.000';

    /**
     * The response code for a request not found.
     */
    const REQUEST_NOT_FOUND = '200.300.404';

    /**
     * The response code for a created checkout.
     */
    const CREATED_PAYMENT_STATUS = '000.100.110';
}
