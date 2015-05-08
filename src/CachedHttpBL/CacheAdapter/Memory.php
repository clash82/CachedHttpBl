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

    /** @var int */
    private $cacheLifeTimeInHours;

    /**
     * Constructs Memory cache adapter object.
     *
     * @param int $cacheLifeTimeInHours
     */
    public function __construct($cacheLifeTimeInHours = 24)
    {
        $this->cacheLifeTimeInHours = $cacheLifeTimeInHours;
    }

    /**
     * {@inheritdoc}
     */
    public function addResponse(Response $response)
    {
        $ip = $response->getIP();
        $this->responseCollection[$ip] = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function responseExists($ip)
    {
        if (array_key_exists($ip, $this->responseCollection)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse($ip)
    {
        if (!array_key_exists($ip, $this->responseCollection)) {
            throw new ResponseNotExists($ip);
        }

        return $this->responseCollection[$ip];
    }

    /**
     * {@inheritdoc}
     */
    public function clearCache()
    {
        $this->responseCollection = array();
    }

    /**
     * {@inheritdoc}
     */
    public function writeCache()
    {
        // do nothing
    }
}
