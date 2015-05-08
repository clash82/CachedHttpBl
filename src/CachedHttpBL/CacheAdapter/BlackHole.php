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
    /**
     * {@inheritdoc}
     */
    public function addResponse(Response $response)
    {
        // do nothing
    }

    /**
     * {@inheritdoc}
     */
    public function responseExists($ip)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse($ip)
    {
        throw new ResponseNotExists($ip);
    }

    /**
     * {@inheritdoc}
     */
    public function clearCache()
    {
        // do nothing
    }

    /**
     * {@inheritdoc}
     */
    public function writeCache()
    {
        // do nothing
    }
}
