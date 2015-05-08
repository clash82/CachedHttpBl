<?php

namespace CachedHttpBL;

use CachedHttpBL\CacheAdapter;
use CachedHttpBL\Provider\ProjectHoneyPot as ProjectHoneyPotProvider;

/**
 * Cached http:BL PHP library.
 *
 * This class performs http:BL service check for IPv4 address (with caching)
 * for more information about http:BL service visit project's home page at:
 * @link http://www.projecthoneypot.org
 *
 * @package CachedHttpBL
 * @version 2.0.0
 * @author Rafał Toborek
 * @link http://toborek.info
 * @link http://github.com/clash82/cachedHttpBl/
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */
class Client
{
    /** @var string */
    private $version = '2.0.0';

    /** @var string */
    private $httpBlApiKey;

    /** @var \CachedHttpBL\CacheAdapter */
    private $adapter;

    /** @var \CachedHttpBl\Provider */
    private $provider;

    /**
     * Constructs ProjectHoneyPot object client.
     *
     * @param string $httpBlApiKey
     * @param \CachedHttpBL\CacheAdapter $adapter
     */
    public function __construct($httpBlApiKey, CacheAdapter $adapter)
    {
        $this->httpBlApiKey = $httpBlApiKey;
        $this->adapter = $adapter;
        $this->provider = new ProjectHoneyPotProvider($httpBlApiKey);
    }

    /**
     * Reports library version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Checks single IP address.
     *
     * @param string $ip
     * @return \CachedHttpBL\Response
     */
    public function checkIP($ip)
    {
        if ($this->adapter->responseExists($ip)) {
            return $this->adapter->getResponse($ip);
        }

        $response = $this->provider->query($ip);
        $this->adapter->addResponse($response);

        return $response;
    }
}
