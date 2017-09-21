<?php

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
    private $responseCollection = array();

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
    public function __construct($cacheFileName, $cacheLifeTimeInHours = 24)
    {
        $this->cacheFileName = $cacheFileName;
        $this->cacheLifeTimeInHours = $cacheLifeTimeInHours;

        $this->loadCache();
    }

    /**
     * Loads response data from file.
     */
    private function loadCache()
    {
        if (!file_exists($this->cacheFileName)) {
            return;
        }

        $cacheLifetimeTimestamp = (new \DateTime())
            ->modify(sprintf('-%d hours', $this->cacheLifeTimeInHours))
            ->getTimestamp();

        $cache = file($this->cacheFileName, FILE_SKIP_EMPTY_LINES);
        foreach ($cache as $line) {
            $responseData = explode(';', $line);

            if ($responseData[1] >= $cacheLifetimeTimestamp) { // do not load outdated data
                $this->addResponse(new ProjectHoneyPot(
                    long2ip($responseData[0]),
                    (int)trim($responseData[1]),
                    empty($responseData[2]) ? null : $responseData[2],
                    empty($responseData[2]) ? null : $responseData[3],
                    empty($responseData[2]) ? null : $responseData[4],
                    empty($responseData[2]) ? null : $responseData[5]
                ));
            }
        }
    }

    public function addResponse(Response $response)
    {
        $ip = $response->getIP();
        $this->responseCollection[$ip] = $response;
    }

    public function responseExists($ip)
    {
        if (array_key_exists($ip, $this->responseCollection)) {
            return true;
        }

        return false;
    }

    public function getResponse($ip)
    {
        if (!array_key_exists($ip, $this->responseCollection)) {
            throw new ResponseNotExists($ip);
        }

        return $this->responseCollection[$ip];
    }

    public function clearCache()
    {
        $this->responseCollection = array();
    }

    public function writeCache()
    {
        $responseData = '';

        foreach ($this->responseCollection as $response) {
            if ($response->getType() == '127') {
                $responseData .= sprintf('%d;%d;%d;%d;%d;%d'.PHP_EOL,
                    ip2long($response->getIP()),
                    $response->getTime(),
                    $response->getType(),
                    $response->getThreat(),
                    $response->getTypeMeaning(),
                    $response->getActivity()
                );
            } else {
                $responseData .= sprintf('%d;%d'.PHP_EOL,
                    ip2long($response->getIP()),
                    $response->getTime()
                );
            }
        }

        if (file_put_contents($this->cacheFileName, $responseData) === false) {
            throw new CacheNotWritable($this->cacheFileName);
        };
    }
}
