<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Security\Token\CryptDrivers\Crypt;

use Webiny\Component\Config\ConfigObject;
use Webiny\Component\Crypt\CryptTrait;
use Webiny\Component\Security\Token\CryptDrivers\CryptDriverInterface;

/**
 * Token crypt driver for Webiny Crypt component.
 *
 * @package         Webiny\Component\Security\Token\CryptDrivers\Crypt
 */
class Crypt implements CryptDriverInterface
{
    use CryptTrait;

    /**
     * @var \Webiny\Component\Crypt\Crypt
     */
    private $serviceInstance = '';

    /**
     * Creates an new crypt driver instance.
     *
     * @throws CryptException
     * @return \Webiny\Component\Security\Token\CryptDrivers\Crypt\Crypt
     */
    public function __construct()
    {
        try {
            $this->serviceInstance = $this->crypt();
        } catch (\Exception $e) {
            throw new CryptException($e->getMessage());
        }
    }

    /**
     * Encrypts the given $string using the $key variable as encryption key.
     *
     * @param string $string Raw string that should be encrypted.
     * @param string $key    Security key used for encryption.
     *
     * @return string Encrypted key.
     */
    public function encrypt($string, $key)
    {
        return $this->serviceInstance->encrypt($string, $key);
    }

    /**
     * Decrypts the given $string that was encrypted with the $key.
     *
     * @param string $string Encrypted string.
     * @param string $key    Key used for encryption.
     *
     * @return string Decrypted string.
     */
    public function decrypt($string, $key)
    {
        return $this->serviceInstance->decrypt($string, $key);
    }
}