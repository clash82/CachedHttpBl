<?php

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
    private $responseCollection = array();

    public function addResponse(Response $response)
    {
        $ip = $response->getIP();
        $this->responseCollection[$ip] = $response;
    }

    public function responseExists($ip)
    {
        if (array_key_exists($ip, $this->responseCollection)) {
            return true;
        }

        return false;
    }

    public function getResponse($ip)
    {
        if (!array_key_exists($ip, $this->responseCollection)) {
            throw new ResponseNotExists($ip);
        }

        return $this->responseCollection[$ip];
    }

    public function clearCache()
    {
        $this->responseCollection = array();
    }

    public function writeCache()
    {
        // do nothing
    }
}
