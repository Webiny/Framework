<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Cache\Bridge;

use \Webiny\Component\StdLib\ValidatorTrait;

/**
 * Webiny cache bridge.
 *
 * @package         Webiny\Component\Cache\Bridge;
 */
abstract class AbstractCache implements StorageInterface
{
    use ValidatorTrait;

    /**
     * Create an instance of a cache driver.
     *
     * @return CacheStorageInterface
     * @throws CacheException
     */
    public static function getInstance()
    {
        $driver = static::getLibrary();

        try {
            $instance = new $driver();
        } catch (\Exception $e) {
            throw new CacheException($e->getMessage());
        }

        if (!self::isInstanceOf($instance, CacheStorageInterface::class)) {
            throw new CacheException(CacheException::MSG_INVALID_ARG, ['driver', CacheStorageInterface::class]);
        }

        return $instance;
    }
}