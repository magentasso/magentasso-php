<?php
namespace MagentaSSO;

class MagentaBase {
	protected string $client_id;
	private string $secret;

	/** @var array<string, mixed> */
	public array $data;

	/**
	 * Create a MagentaBase.
	 *
	 * @param string $client_id The Magenta client ID
	 * @param string $secret The Magenta client secret
	 * @param array<string, mixed> $data The request/response data
	 */
	public function __construct(string $client_id, string $secret, array $data = []) {
		$this->client_id = $client_id;
		$this->secret = $secret;
		$this->data = $data;
	}

	/**
	 * Verify the signature, decode the payload, and store the payload as $this->data
	 *
	 * @param string $payload The encoded payload
	 * @param string $signature The encoded signature
	 */
	public function decode(string $payload, string $signature): void {
		$this->data = Utilities::verify_and_decode($payload, $signature, $this->secret);
	}
	
	/**
	 * Encode $this->data and sign with $this->secret
	 *
	 * @return string[] An array of [payload, secret]
	 */
	public function encode(): array {
		return Utilities::encode_and_sign($this->data, $this->secret);
	}
	
	/**
	 * Convert this MagentaBase to a query string, encoding our data using
	 * $this->encode()
	 *
	 * @return string The encoded query string
	 */
	public function __tostring(): string {
		list($payload, $signature) = $this->encode();
		return http_build_query([
			'client' => $this->client_id,
			'payload' => $payload,
			'signature' => $signature,
		]);
	}
}
