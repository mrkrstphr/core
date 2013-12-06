<?php

namespace Martha\Core\Authentication;

/**
 * Class PasswordHasher
 *
 * Adapted from: https://crackstation.net/hashing-security.htm
 *
 * @package Martha\Core\Authentication
 * @author havoc AT defuse.ca
 */
class PasswordFactory
{
    const PBKDF2_HASH_ALGORITHM = 'sha256';
    const PBKDF2_ITERATIONS = 1000;
    const PBKDF2_SALT_BYTE_SIZE = 24;
    const PBKDF2_HASH_BYTE_SIZE = 24;
    
    const HASH_SECTIONS = 4;
    const HASH_ALGORITHM_INDEX = 0;
    const HASH_ITERATION_INDEX = 1;
    const HASH_SALT_INDEX = 2;
    const HASH_PBKDF2_INDEX = 3;

    /**
     * Creates a hashed password string for the provided password.
     *
     * @param string $password
     * @return string
     */
    public function create($password)
    {
        // format: algorithm:iterations:salt:hash
        $salt = base64_encode(mcrypt_create_iv(self::PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));

        return self::PBKDF2_HASH_ALGORITHM . ':' . self::PBKDF2_ITERATIONS . ':' .  $salt . ':' .
            base64_encode(
                $this->pbkdf2(
                    self::PBKDF2_HASH_ALGORITHM,
                    $password,
                    $salt,
                    self::PBKDF2_ITERATIONS,
                    self::PBKDF2_HASH_BYTE_SIZE,
                    true
                )
            );
    }

    /**
     * Determines if the passed plaintext $password matches the correct hash $hash.
     *
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public function validate($password, $hash)
    {
        $params = explode(':', $hash);

        if (count($params) < HASH_SECTIONS) {
            return false;
        }

        $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);

        return $this->slowEquals(
            $pbkdf2,
            $this->pbkdf2(
                $params[HASH_ALGORITHM_INDEX],
                $password,
                $params[HASH_SALT_INDEX],
                (int)$params[HASH_ITERATION_INDEX],
                strlen($pbkdf2),
                true
            )
        );
    }

    /**
     * Compares two strings $a and $b in length-constant time.
     *
     * @param string $a
     * @param string $b
     * @return bool
     */
    protected function slowEquals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);

        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }

        return $diff === 0;
    }

    /**
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     *
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     *
     * @throws HashingException
     * @param string $algorithm The hash algorithm to use. Recommended: SHA256
     * @param string $password The password.
     * @param string $salt A salt that is unique to the password.
     * @param int $count Iteration count. Higher is better, but slower. Recommended: At least 1000.
     * @param int $keyLength The length of the derived key in bytes.
     * @param boolean $rawOutput If true, the key is returned in raw binary format. Hex encoded otherwise.
     * @return string A $key_length-byte key derived from the password and salt.
     */
    protected function pbkdf2($algorithm, $password, $salt, $count, $keyLength, $rawOutput = false)
    {
        $algorithm = strtolower($algorithm);
        if (!in_array($algorithm, hash_algos(), true)) {
            throw new HashingException('PBKDF2 ERROR: Invalid hash algorithm.');
        }

        if ($count <= 0 || $keyLength <= 0) {
            throw new HashingException('PBKDF2 ERROR: Invalid parameters.');
        }

        $hashLength = strlen(hash($algorithm, '', true));
        $blockCount = ceil($keyLength / $hashLength);

        $output = '';
        for ($i = 1; $i <= $blockCount; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack('N', $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if ($rawOutput) {
            return substr($output, 0, $keyLength);
        }

        return bin2hex(substr($output, 0, $keyLength));
    }
}
