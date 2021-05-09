<?php
namespace MagentaSSO;

class MagentaRequest extends MagentaBase {
	/**
	 * Create a MagentaRequest.
	 *
	 * @param string $client_id The Magenta client ID
	 * @param string $secret The Magenta client secret
	 * @param ?int $nonce A nonce value (randomly generated if `null`)
	 * @param string[] $scopes The list of scopes to request
	 * @param string $callback_url The URL that the Magenta server will call back to
	 */
	public function __construct(string $client_id, string $secret, ?int $nonce = null, ?array $scopes = null, ?string $callback_url = null) {
		$nonce ??= random_int(1000000, 9999999);

		$data = [
			'client_id' => $client_id,
			'nonce' => $nonce,
			'scopes' => $scopes ?? [],
			'callback_url' => $callback_url,
		];

		parent::__construct($client_id, $secret, $data);
	}
}
