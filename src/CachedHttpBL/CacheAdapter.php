<?php declare(strict_types=1);

namespace CachedHttpBL;

use CachedHttpBL\Exception\ResponseNotExistsException;

/**
 * Interface for the CachedHttpBL cache adapter.
 */
interface CacheAdapter
{
    /**
     * Adds response to collection.
     */
    public function addResponse(Response $response): void;

    /**
     * Checks if response exists in a collection.
     *
     * @param string $ip IPv4 address
     */
    public function responseExists(string $ip): bool;

    /**
     * Gets response for specific IPv4 address.
     *
     * @param string $ip IPv4 address
     *
     * @throws ResponseNotExistsException if response was not found in a collection
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
