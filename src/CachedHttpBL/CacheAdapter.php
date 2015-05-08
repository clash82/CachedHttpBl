<?php

namespace CachedHttpBL;

use CachedHttpBl\Response;

/**
 * Interface for the CachedHttpBL cache adapter.
 *
 * @package CachedHttpBL
 * @author Rafał Toborek
 */
interface CacheAdapter
{
    /**
     * Adds response to collection.
     *
     * @param \CachedHttpBl\Response $response
     */
    public function addResponse(Response $response);

    /**
     * Checks if response exists in a collection.
     *
     * @param $ip string IPv4 address
     * @return bool
     */
    public function responseExists($ip);

    /**
     * Gets response for specific IPv4 address.
     *
     * @param $ip string IPv4 address
     * @return \CachedHttpBl\Response
     * @throws \CachedHttpBl\Exception\ResponseNotExists if response was not found in a collection
     */
    public function getResponse($ip);

    /**
     * Writes cache to external storage.
     */
    public function writeCache();

    /**
     * Purge cached data.
     */
    public function clearCache();
}
