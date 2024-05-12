<?php
class JWT
{
    /**
     * Generate JWT
     * @param array $header Token header
     * @param array $payload Token payload
     * @param string $secret Secret key
     * @param int $validity Validity duration (in seconds)
     * @return string Token
     */
    public static function generate($header, $payload, $secret, $validity = null)
    {
        if ($validity === null) {
            $validity = 86400;
        }

        if ($validity > 0) {
            $now = new DateTime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiration;
        }

        // Encoding in base64
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // "Cleaning" encoded values
        // Removing +, /, and =
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        // Generating signature
        // $secret = base64_encode($secret);
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        // Creating token
        $jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

        return $jwt;
    }

    /**
     * Token verification
     * @param string $token Token to verify
     * @param string $secret Secret key
     * @return bool Verified or not
     */
    public static function check($token, $secret)
    {
        // Retrieving header and payload
        $header = JWT::getHeader($token);
        $payload = JWT::getPayload($token);

        // Generating a verification token
        $verifToken = JWT::generate($header, $payload, $secret, 0);

        return $token === $verifToken;
    }

    /**
     * Get header
     * @param string $token Token
     * @return array Header
     */
    public static function getHeader($token)
    {
        // Token breakdown
        $array = explode('.', $token);

        // Decoding the header
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    /**
     * Get payload
     * @param string $token Token
     * @return array Payload
     */
    public static function getPayload($token)
    {
        // Token breakdown
        $array = explode('.', $token);

        // Decoding the payload
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    /**
     * Expiration verification
     * @param string $token Token to verify
     * @return bool Verified or not
     */
    public static function isExpired($token)
    {
        $payload = JWT::getPayload($token);

        $now = new DateTime();

        return $payload['exp'] < $now->getTimestamp();
    }

    /**
     * Token validity check
     * @param string $token Token to check
     * @return bool Verified or not
     */
    public static function isValid($token)
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }
}
