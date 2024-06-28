<?php

/**
 * Hash the password with Bcrypt. 
 * Before the actual BCRYPT hash proccess, the password is hashed in sha256,
 * being the pre-configured pepper the key.
 * 
 * @param string the password to be hashed.
 * @return string the password hash.
 */
function hashPassword(string $password): string
{
    $pepper = $_ENV['PASSWORD_PEPPER'];

    $pepperedPassword = hash_hmac("sha256", $password, $pepper);
    $hashedPassword = password_hash($pepperedPassword, PASSWORD_BCRYPT);

    return $hashedPassword;
}

/**
 * Verifies if the provided password matches the hashed password stored in the database.
 *
 * @param string $password The password provided by the user during login.
 * @param string $hashedPassword The hashed password stored in the database.
 * @return bool Returns true if the provided password, after being processed with the system's hash,
 * matches the stored hashed password; otherwise, returns false.
 */
function verifyPassword($password, string $hashedPassword): bool
{
    $pepperedPassword = hash_hmac("sha256", $password, $_ENV['PASSWORD_PEPPER']);

    return password_verify($pepperedPassword, $hashedPassword);
}
