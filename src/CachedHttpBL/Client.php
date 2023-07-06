<?php declare(strict_types=1);

namespace CachedHttpBL;

use CachedHttpBL\Provider\ProjectHoneyPot as ProjectHoneyPotProvider;

/**
 * Cached http:BL PHP library.
 *
 * This class performs http:BL service check for IPv4 address (with caching)
 * for more information about http:BL service visit project's home page at:
 * @link https://www.projecthoneypot.org
 *
 * @version 3.0.0
 * @author Rafał Toborek
 * @link https://toborek.info/about/
 * @link https://github.com/clash82/cachedHttpBl/
 * @license https://www.gnu.org/licenses/gpl-3.0.txt
 */
class Client
{
    /** @var string */
    private $version = '3.0.0';

    /** @var \CachedHttpBL\CacheAdapter */
    private $adapter;

    /** @var \CachedHttpBL\Provider */
    private $provider;

    /**
     * Constructs client.
     *
     * @param \CachedHttpBL\Provider $provider
     * @param \CachedHttpBL\CacheAdapter $adapter
     */
    public function __construct(Provider $provider, CacheAdapter $adapter)
    {
        $this->adapter = $adapter;
        $this->provider = $provider;
    }

    /**
     * Reports library version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Checks single IP address.
     *
     * @param string $ip
     * @return \CachedHttpBL\Response
     */
    public function checkIP(string $ip): Response
    {
        if ($this->adapter->responseExists($ip)) {
            return $this->adapter->getResponse($ip);
        }

        $response = $this->provider->query($ip);
        $this->adapter->addResponse($response);

        return $response;
    }
}
