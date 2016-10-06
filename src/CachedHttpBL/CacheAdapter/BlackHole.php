<?php

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
    public function addResponse(Response $response)
    {
        // do nothing
    }

    public function responseExists($ip)
    {
        return false;
    }

    public function getResponse($ip)
    {
        throw new ResponseNotExists($ip);
    }

    public function clearCache()
    {
        // do nothing
    }

    public function writeCache()
    {
        // do nothing
    }
}
