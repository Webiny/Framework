<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Cache\Bridge;

use Webiny\Component\Cache\Cache;
use Webiny\Component\Cache\CacheException;

/**
 * Couchbase cache bridge loader.
 *
 * @package         Webiny\Component\Cache\Bridge
 */
class Couchbase extends AbstractCache
{

    /**
     * Path to the default bridge library for APC.
     *
     * @var string
     */
    private static $library = Memory\Couchbase::class;

    /**
     * Get the name of bridge library which will be used as the driver.
     *
     * @return string
     */
    public static function getLibrary()
    {
        return Cache::getConfig()->get('Bridges.Couchbase', self::$library);
    }

    /**
     * Change the default library used for the driver.
     *
     * @param string $pathToClass Path to the new driver class. Must be an instance of \Webiny\Component\Cache\Bridge\CacheInterface
     */
    public static function setLibrary($pathToClass)
    {
        self::$library = $pathToClass;
    }

    /**
     * Override the AbstractCache::getInstance method.
     *
     * @see      CacheAbstract::getInstance()
     *
     * @param string $user Couchbase username.
     * @param string $password Couchbase password.
     * @param string $bucket Couchbase bucket.
     * @param string $host Couchbase host (with port number).
     *
     * @throws \Webiny\Component\Cache\CacheException
     * @internal param \Couchbase $couchbase Instance of Couchbase class.
     *
     * @return void|CacheStorageInterface
     */
    public static function getInstance($user = '', $password = '', $bucket = '', $host = '127.0.0.1:8091')
    {
        $driver = static::getLibrary();

        // check if Couchbase extension is loaded
        if (!class_exists('Couchbase', true)) {
            throw new CacheException('The "Couchbase" SDK must be installed if you wish to use Couchbase.
										For more information visit: http://www.couchbase.com/develop/php/current');
        } else {
            $couchbase = new \Couchbase($host, $user, $password, $bucket);
        }

        try {
            $instance = new $driver($couchbase);
        } catch (\Exception $e) {
            throw new CacheException($e->getMessage());
        }

        if (!self::isInstanceOf($instance, CacheStorageInterface::class)) {
            throw new CacheException(CacheException::MSG_INVALID_ARG, ['driver', CacheStorageInterface::class]);
        }

        return $instance;
    }
}