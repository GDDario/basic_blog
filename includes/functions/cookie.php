<?php

require __DIR__ . '/../../config/config.php';

/**
 * Hash the "keep me logged in" cookie with some cryptography. 
 * 
 * @param int $userId the user id to be hashed into the cookie.
 *
 * @return void
 */
function createKeepMeLoggedInCookie(int $userId): void
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    $encryptedId = openssl_encrypt((string)$userId, 'aes-256-cbc', $_ENV['KEEP_ME_LOGGED_IN_HASH_KEY'], 0, $iv);
    $hashedCookieValue = base64_encode($iv . $encryptedId);

    setcookie("KEEPCONNECTED", $hashedCookieValue, time() + $_ENV['KEEP_ME_LOGGED_IN_DURATION'], "/");
}

function extractUserIdFromKeepMeLoggedInCookie(): mixed
{
    if (!isset($_COOKIE['KEEPCONNECTED'])) {
        return null;
    }

    $hashedCookieValue = $_COOKIE['KEEPCONNECTED'];
    $decodedData = base64_decode($hashedCookieValue);
    $iv = substr($decodedData, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedId = substr($decodedData, openssl_cipher_iv_length('aes-256-cbc'));

    if (hash_equals($hashedCookieValue, base64_encode($iv . $encryptedId))) {
        $decryptedId = openssl_decrypt($encryptedId, 'aes-256-cbc', $_ENV['KEEP_ME_LOGGED_IN_HASH_KEY'], 0, $iv);

        return (int) $decryptedId;
    } else {
        return null;
    }
}
