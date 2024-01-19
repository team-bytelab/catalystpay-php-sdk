<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use CatalystPay\CatalystPaySDK;

abstract class TestCase extends BaseTestCase
{
	public function getCatalystPayConfig()
	{

		$catalystPayConfig = new CatalystPaySDK(
			getenv('CATALYST_PAY_TOKEN'),
			getenv('CATALYST_PAY_ENTITY_ID'),
			(bool) getenv('CATALYST_PAY_IS_PRODUCTION')

		);
		return $catalystPayConfig;
	}
}
