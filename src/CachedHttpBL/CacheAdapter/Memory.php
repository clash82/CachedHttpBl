<?php declare(strict_types=1);

namespace CachedHttpBL\CacheAdapter;

use CachedHttpBL\Response;
use CachedHttpBL\CacheAdapter;
use CachedHttpBL\Exception\ResponseNotExists;

/**
 * In memory cache adapter.
 * (this adapter prevents using caching)
 *
 * @package CachedHttpBL\CacheAdapter
 * @author Rafał Toborek
 */
class Memory implements CacheAdapter
{
    /** @var array */
    private $responseCollection = [];

    public function addResponse(Response $response): void
    {
        $ip = $response->getIP();
        $this->responseCollection[$ip] = $response;
    }

    public function responseExists(string $ip): bool
    {
        if (isset($this->responseCollection[$ip])) {
            return true;
        }

        return false;
    }

    public function getResponse(string $ip): Response
    {
        if (!isset($this->responseCollection[$ip])) {
            throw new ResponseNotExists($ip);
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
