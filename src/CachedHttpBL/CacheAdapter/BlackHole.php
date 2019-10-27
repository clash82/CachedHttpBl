<?php declare(strict_types=1);

namespace CachedHttpBL\CacheAdapter;

use CachedHttpBL\Response;
use CachedHttpBL\CacheAdapter;
use CachedHttpBL\Exception\ResponseNotExists;

/**
 * BlackHole cache adapter.
 *
 * @package CachedHttpBL\CacheAdapter
 * @author Rafał Toborek
 */
class BlackHole implements CacheAdapter
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
        throw new ResponseNotExists($ip);
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
