<?php declare(strict_types=1);

namespace CachedHttpBL\CacheAdapter;

use CachedHttpBL\CacheAdapter;
use CachedHttpBL\Exception\CacheNotWritableException;
use CachedHttpBL\Exception\ResponseNotExistsException;
use CachedHttpBL\Provider\ProjectHoneyPotProvider;
use CachedHttpBL\Response;
use CachedHttpBL\Response\ProjectHoneyPotResponse;
use DateTime;

/**
 * CSV file cache adapter.
 */
class CSVCacheAdapter implements CacheAdapter
{
    /** @var array<string, Response> */
    private array $responseCollection = [];

    /**
     * Constructs CSV cache adapter object.
     */
    public function __construct(
        private readonly string $cacheFileName,
        private readonly int $cacheLifeTimeInHours = 24
    ) {
        $this->loadCache();
    }

    public function addResponse(Response $response): void
    {
        $ip = $response->getIP();
        $this->responseCollection[$ip] = $response;
    }

    public function responseExists(string $ip): bool
    {
        return isset($this->responseCollection[$ip]);
    }

    public function getResponse(string $ip): Response
    {
        if (!isset($this->responseCollection[$ip])) {
            throw new ResponseNotExistsException($ip);
        }

        return $this->responseCollection[$ip];
    }

    public function clearCache(): void
    {
        $this->responseCollection = [];
    }

    public function writeCache(): void
    {
        $responseData = '';

        foreach ($this->responseCollection as $response) {
            $responseEntry = sprintf(
                '%d;%d'.\PHP_EOL,
                ip2long($response->getIP()),
                $response->getTime()
            );

            if ($response->getType() === ProjectHoneyPotProvider::TYPE_SUCCESS) {
                $responseEntry = sprintf(
                    '%d;%d;%d;%d;%d;%d'.\PHP_EOL,
                    ip2long($response->getIP()),
                    $response->getTime(),
                    $response->getType(),
                    $response->getThreat(),
                    $response->getTypeMeaning(),
                    $response->getActivity()
                );
            }

            $responseData .= $responseEntry;
        }

        if (file_put_contents($this->cacheFileName, $responseData) === false) {
            throw new CacheNotWritableException($this->cacheFileName);
        }
    }

    /**
     * Loads response data from file.
     */
    private function loadCache(): void
    {
        if (!file_exists($this->cacheFileName)) {
            return;
        }

        $cacheLifetimeTimestamp = (new DateTime())
            ->modify(sprintf('-%d hours', $this->cacheLifeTimeInHours))
            ->getTimestamp();

        $cache = file($this->cacheFileName, \FILE_SKIP_EMPTY_LINES);

        if (!\is_array($cache)) {
            return;
        }

        foreach ($cache as $line) {
            $responseData = explode(';', $line);

            if ($responseData[1] >= $cacheLifetimeTimestamp) { // do not load outdated data
                $this->addResponse(new ProjectHoneyPotResponse(
                    (string)long2ip((int)$responseData[0]),
                    (int) trim($responseData[1]),
                    empty($responseData[2]) ? -1 : (int)$responseData[2],
                    empty($responseData[2]) ? -1 : (int)$responseData[3],
                    empty($responseData[2]) ? -1 : (int)$responseData[4],
                    empty($responseData[2]) ? -1 : (int)$responseData[5]
                ));
            }
        }
    }
}
