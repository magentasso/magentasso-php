<?php

use PHPUnit\Framework\TestCase;
use MagentaSSO\MagentaBase;

final class MagentaBaseTest extends TestCase {
	public function test_decode() {
		$instance = new MagentaBase("test", TEST_SECRET);
		$instance->decode("eyJ0ZXN0Ijp0cnVlfQ", "AHlrP-r0AtZ_zK-uQTUqdBPH85q-Ezu3mDUdlSnndMQ");
		
		$this->assertEquals($instance->data, ['test' => true]);
	}
	
	public function test_encode() {
		$instance = new MagentaBase("test", TEST_SECRET);
		$instance->data = ['test' => true];
		
		list($payload, $signature) = $instance->encode();
		$this->assertEquals($payload, "eyJ0ZXN0Ijp0cnVlfQ==");
		$this->assertEquals($signature, "oATdmo0RGp204cG0awcqGhOaY6R2OWMIut4hEp51pI4=");
	}
	
	public function test_to_string() {
		$instance = new MagentaBase("test", TEST_SECRET);
		$instance->data = ['test' => true];

		$this->assertEquals((string) $instance, 'client=test&payload=eyJ0ZXN0Ijp0cnVlfQ%3D%3D&signature=oATdmo0RGp204cG0awcqGhOaY6R2OWMIut4hEp51pI4%3D');
	}
}
