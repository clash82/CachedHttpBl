<?php declare(strict_types=1);

namespace CachedHttpBL\Provider;

use CachedHttpBL\Exception\UnexpectedResponseException;
use CachedHttpBL\Provider;
use CachedHttpBL\Response as Response;

/**
 * ProjectHoneyPot's http:BL service client.
 */
class ProjectHoneyPotProvider implements Provider
{
    final public const int TYPE_SUCCESS = 127;

    /**
     * Constructs ProjectHoneyPot client service.
     */
    public function __construct(private readonly string $httpBlApiKey)
    {
    }

    public function query(string $ip): Response\ProjectHoneyPotResponse
    {
        $lookupResult = $this->lookup($ip);

        [$type, $activity, $threat, $typeMeaning] = explode('.', $lookupResult);

        if ((int)$type !== self::TYPE_SUCCESS) {
            throw new UnexpectedResponseException($ip);
        }

        return new Response\ProjectHoneyPotResponse(
            $ip,
            time(),
            (int)$type,
            (int)$threat,
            (int)$typeMeaning,
            (int)$activity
        );
    }

    /**
     * Perform DNS lookup.
     *
     * @param string $ip IPv4 address
     */
    private function lookup(string $ip): string
    {
        $lookup = $this->httpBlApiKey.'.'.implode('.', array_reverse(explode('.', $ip))).'.dnsbl.httpbl.org';

        return gethostbyname($lookup);
    }
}
