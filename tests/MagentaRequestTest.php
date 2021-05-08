<?php

use PHPUnit\Framework\TestCase;
use MagentaSSO\MagentaRequest;

final class MagentaRequestTest extends TestCase {
	public function test_construct() {
		$instance = new MagentaRequest("test", TEST_SECRET, null, ['user'], "http://localhost");

		$this->assertNotEquals($instance->data['nonce'], null);
		$this->assertEquals($instance->data['scopes'], ['user']);
		$this->assertEquals($instance->data['callback_url'], 'http://localhost');
	}
}
