<?php declare(strict_types=1);

namespace CachedHttpBL\CacheAdapter;

use CachedHttpBL\Response;
use CachedHttpBL\Response\ProjectHoneyPot;
use CachedHttpBL\CacheAdapter;
use CachedHttpBL\Exception\CacheNotWritable;
use CachedHttpBL\Exception\ResponseNotExists;

/**
 * CSV file cache adapter.
 *
 * @package CachedHttpBL\CacheAdapter
 * @author Rafał Toborek
 */
class CSV implements CacheAdapter
{
    /** @var array */
    private $responseCollection = [];

    /** @var string */
    private $cacheFileName;

    /** @var int */
    private $cacheLifeTimeInHours;

    /**
     * Constructs CSV cache adapter object.
     *
     * @param string $cacheFileName
     * @param int $cacheLifeTimeInHours
     */
    public function __construct(string $cacheFileName, int $cacheLifeTimeInHours = 24)
    {
        $this->cacheFileName = $cacheFileName;
        $this->cacheLifeTimeInHours = $cacheLifeTimeInHours;

        $this->loadCache();
    }

    /**
     * Loads response data from file.
     */
    private function loadCache(): void
    {
        if (!file_exists($this->cacheFileName)) {
            return;
        }

        $cacheLifetimeTimestamp = (new \DateTime())
            ->modify(sprintf('-%d hours', $this->cacheLifeTimeInHours))
            ->getTimestamp();

        $cache = file($this->cacheFileName, FILE_SKIP_EMPTY_LINES);
        if (!is_array($cache)) {
            return;
        }

        foreach ($cache as $line) {
            $responseData = explode(';', $line);

            if ($responseData[1] >= $cacheLifetimeTimestamp) { // do not load outdated data
                $this->addResponse(new ProjectHoneyPot(
                    long2ip((int)$responseData[0]),
                    (int) trim($responseData[1]),
                    empty($responseData[2]) ? -1 : (int)$responseData[2],
                    empty($responseData[2]) ? -1 : (int)$responseData[3],
                    empty($responseData[2]) ? -1 : (int)$responseData[4],
                    empty($responseData[2]) ? -1 : (int)$responseData[5]
                ));
            }
        }
    }

    public function addResponse(Response $response): void
    {
        $ip = $response->getIP();
        $this->responseCollection[$ip] = $response;
    }

    public function responseExists(string $ip): bool
    {
        if (isset($this->responseCollection[$ip])) {
            return true;
        }

        return false;
    }

    public function getResponse(string $ip): Response
    {
        if (!isset($this->responseCollection[$ip])) {
            throw new ResponseNotExists($ip);
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
            $responseEntry = sprintf('%d;%d'.PHP_EOL,
                ip2long($response->getIP()),
                $response->getTime()
            );

            if ($response->getType() == '127') {
                $responseEntry = sprintf('%d;%d;%d;%d;%d;%d'.PHP_EOL,
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
            throw new CacheNotWritable($this->cacheFileName);
        };
    }
}
