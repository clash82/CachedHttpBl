<?php

namespace CachedHttpBL;

/**
 * Interface for the CachedHttpBL service provider.
 *
 * @package CachedHttpBL
 * @author Rafał Toborek
 */
interface Provider
{
    /**
     * Query http:BL service for a single IP address.
     *
     * @param $ip string IPv4 address
     * @return \CachedHttpBl\Response\ProjectHoneyPot
     * @throws \CachedHttpBl\Exception\UnexpectedResponse if http:BL returns $type different than 127
     */
    public function query($ip);
}
