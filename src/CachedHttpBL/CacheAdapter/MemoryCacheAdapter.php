<?php declare(strict_types=1);

namespace CachedHttpBL\CacheAdapter;

use CachedHttpBL\CacheAdapter;
use CachedHttpBL\Exception\ResponseNotExistsException;
use CachedHttpBL\Response;

/**
 * In memory cache adapter.
 * (this adapter prevents using caching).
 */
class MemoryCacheAdapter implements CacheAdapter
{
    /** @var array<string, Response> */
    private array $responseCollection = [];

    public function addResponse(Response $response): void
    {
        $ip = $response->getIP();
        $this->responseCollection[$ip] = $response;
    }

    public function responseExists(string $ip): bool
    {
        return isset($this->responseCollection[$ip]);
    }

    public function getResponse(string $ip): Response
    {
        if (!isset($this->responseCollection[$ip])) {
            throw new ResponseNotExistsException($ip);
        }

        return $this->responseCollection[$ip];
    }

    public function clearCache(): void
    {
        $this->responseCollection = [];
    }

    public function writeCache(): void
    {
        // do nothing
    }
}
