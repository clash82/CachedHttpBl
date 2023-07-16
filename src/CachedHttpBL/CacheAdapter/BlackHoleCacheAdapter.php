<?php declare(strict_types=1);

namespace CachedHttpBL\CacheAdapter;

use CachedHttpBL\CacheAdapter;
use CachedHttpBL\Exception\ResponseNotExistsException;
use CachedHttpBL\Response;

/**
 * BlackHole cache adapter.
 */
class BlackHoleCacheAdapter implements CacheAdapter
{
    public function addResponse(Response $response): void
    {
        // do nothing
    }

    public function responseExists(string $ip): bool
    {
        return false;
    }

    public function getResponse(string $ip): Response
    {
        throw new ResponseNotExistsException($ip);
    }

    public function clearCache(): void
    {
        // do nothing
    }

    public function writeCache(): void
    {
        // do nothing
    }
}
