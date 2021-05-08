<?php

use PHPUnit\Framework\TestCase;
use MagentaSSO\Utilities;

final class UtilitiesTest extends TestCase {
	public function test_encode_and_sign_encodes_payload() {
	    list($payload, $signature) = Utilities::encode_and_sign(['test' => true], TEST_SECRET);
		$decoded_payload = json_decode(Utilities::base64_urldecode($payload), true);

		$this->assertEquals($decoded_payload, ['test' => true]);
	}

	public function test_encode_and_sign_signs_payload() {
	    list($payload, $signature) = Utilities::encode_and_sign(['test' => true], TEST_SECRET);
		$this->assertEquals($signature, "oATdmo0RGp204cG0awcqGhOaY6R2OWMIut4hEp51pI4=");
	}

	public function test_verify_and_decode() {
		$payload = Utilities::verify_and_decode(
			"eyJ0ZXN0Ijp0cnVlfQ",
			"AHlrP-r0AtZ_zK-uQTUqdBPH85q-Ezu3mDUdlSnndMQ",
			TEST_SECRET,
		);

		$this->assertEquals($payload, ['test' => true]);
	}
}
