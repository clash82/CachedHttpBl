<?php declare(strict_types=1);

namespace CachedHttpBL;

/**
 * Cached http:BL PHP library.
 *
 * This class performs http:BL service check for IPv4 address (with caching)
 * for more information about http:BL service visit project's home page at:
 * @link https://www.projecthoneypot.org
 *
 * @version 4.2.0
 * @author Rafał Toborek
 * @link https://kontakt.toborek.info
 * @link https://github.com/clash82/CachedHttpBl
 * @license https://www.gnu.org/licenses/gpl-3.0.txt
 */
class Client
{
    private string $version = '4.2.0';

    /**
     * Constructs ProjectHoneyPot object client.
     */
    public function __construct(
        private readonly Provider $provider,
        private readonly CacheAdapter $adapter
    ) {
    }

    /**
     * Reports library version.
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Checks single IP address.
     *
     * @param string $ip IPv4 address
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
