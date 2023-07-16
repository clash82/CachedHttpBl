<?php declare(strict_types=1);

namespace CachedHttpBL;

use CachedHttpBL\Exception\UnexpectedResponseException;
use CachedHttpBL\Response\ProjectHoneyPotResponse;

/**
 * Interface for the CachedHttpBL service provider.
 */
interface Provider
{
    /**
     * Query http:BL service for a single IP address.
     *
     * @param string $ip IPv4 address
     *
     * @throws UnexpectedResponseException if http:BL returns $type different from 127
     */
    public function query(string $ip): ProjectHoneyPotResponse;
}
