<?php declare(strict_types=1);

namespace CachedHttpBL;

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
    public function addResponse(Response $response): void;

    /**
     * Checks if response exists in a collection.
     *
     * @param $ip string IPv4 address
     * @return bool
     */
    public function responseExists(string $ip): bool;

    /**
     * Gets response for specific IPv4 address.
     *
     * @param $ip string IPv4 address
     * @return \CachedHttpBl\Response
     * @throws \CachedHttpBl\Exception\ResponseNotExists if response was not found in a collection
     */
    public function getResponse(string $ip): Response;

    /**
     * Writes cache to external storage.
     */
    public function writeCache(): void;

    /**
     * Purge cached data.
     */
    public function clearCache(): void;
}
