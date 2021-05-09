<?php
namespace MagentaSSO;

class MagentaResponse extends MagentaBase {
	/**
	 * Create a MagentaResponse.
	 *
	 * @param string $client_id The Magenta client ID
	 * @param string $secret The Magenta client secret
	 * @param ?int $nonce A nonce value (randomly generated if `null`)
	 * @param array<string, mixed> $user_data Data about the authenticated user
	 * @param array<string, mixed> $scope_data Scoped data about the authenticated user, as per a MagentaRequest
	 */
	public function __construct(string $client_id, string $secret, ?int $nonce = null, ?array $user_data = null, ?array $scope_data = null) {
		$nonce ??= random_int(1000000, 9999999);

		$data = [
			'client_id' => $client_id,
			'nonce' => $nonce,
			'user_data' => $user_data ?? [],
			'scope_data' => $scope_data ?? [],
		];

		parent::__construct($client_id, $secret, $data);
	}
}
