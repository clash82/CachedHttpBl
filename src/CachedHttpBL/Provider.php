<?php declare(strict_types=1);

namespace CachedHttpBL;

use CachedHttpBL\Response\ProjectHoneyPot;

/**
 * Interface for the CachedHttpBL service provider.
 *
 * @author Rafał Toborek
 */
interface Provider
{
    /**
     * Query http:BL service for a single IP address.
     *
     * @param string $ip IPv4 address
     * @return \CachedHttpBL\Response\ProjectHoneyPot
     * @throws \CachedHttpBL\Exception\UnexpectedResponse if http:BL returns $type different than 127
     */
    public function query(string $ip): ProjectHoneyPot;
}
