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
}
