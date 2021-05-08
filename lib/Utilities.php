<?php
namespace MagentaSSO;

use Base32\Base32;

final class Utilities {
	/**
	 * Decode a URL-encoded Base64 string
	 *
	 * @param string $data The URL-encoded Base64 data
	 * @return string The decoded data
	 */
	public static function base64_urldecode(string $data): string {
		return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
	}

	/**
	 * Encode a string to URL-encoded Base64
	 *
	 * @param string $data The data to encode
	 * @return string The URL-encoded Base64 data
	 */
	public static function base64_urlencode(string $data): string {
		return str_replace(['+', '/'], ['-', '_'], base64_encode($data));
	}

	/**
	 * Encode the payload and sign it with the secret
	 *
	 * @param mixed $payload The payload
	 * @param string $secret The secret
	 * @return string[] An array of [payload, secret]
	 */
	public static function encode_and_sign($payload, string $secret): array {
		$secret = Base32::decode($secret);

		// Encode payload
		$payload = json_encode($payload);
		if ($payload === false) $payload = '';
		$payload = self::base64_urlencode($payload);

		// Sign the payload
		$signature = hash_hmac("sha256", $payload, $secret, true);
		$signature = self::base64_urlencode($signature);

		return [$payload, $signature];
	}

	/**
	 * Verify the signature and decode the payload
	 *
	 * @param string $payload The encoded payload
	 * @param string $signature The encoded signature
	 * @param string $secret The secret
	 * @return mixed The decoded payload
	 */
	public static function verify_and_decode(string $payload, string $signature, string $secret) {
		$secret = Base32::decode($secret);

		// Check signature
		$signature = self::base64_urldecode($signature);
		$our_signature = hash_hmac("sha256", $payload, $secret, true);
		if ($our_signature !== $signature) {
			throw new MagentaSignatureException();
		}

		// Decode payload
		$payload = self::base64_urldecode($payload);
		return json_decode($payload, true);
	}
}