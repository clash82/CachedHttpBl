<?php declare(strict_types=1);

namespace CachedHttpBL\Provider;

use CachedHttpBL\Exception\UnexpectedResponse;
use CachedHttpBL\Provider;
use CachedHttpBL\Response as Response;

/**
 * ProjectHoneyPot's http:BL service client.
 *
 * @author Rafał Toborek
 */
class ProjectHoneyPot implements Provider
{
    /** @var string */
    private $httpBlApiKey;

    /**
     * Constructs ProjectHoneyPot client service.
     *
     * @param string $httpBlApiKey
     */
    public function __construct(string $httpBlApiKey)
    {
        $this->httpBlApiKey = $httpBlApiKey;
    }

    public function query(string $ip): Response\ProjectHoneyPot
    {
        $lookupResult = $this->lookup($ip);

        list($type, $activity, $threat, $typeMeaning) = explode('.', $lookupResult);

        if ((int)$type != 127) {
            throw new UnexpectedResponse($ip);
        }

        $response = new Response\ProjectHoneyPot(
            $ip,
            time(),
            (int)$type,
            (int)$threat,
            (int)$typeMeaning,
            (int)$activity
        );

        return $response;
    }

    /**
     * Perform DNS lookup.
     *
     * @param string $ip
     * @return string
     */
    private function lookup(string $ip): string
    {
        $lookup = $this->httpBlApiKey.'.'.implode('.', array_reverse(explode('.', $ip))).'.dnsbl.httpbl.org';
        $result = gethostbyname($lookup);

        return $result;
    }
}
