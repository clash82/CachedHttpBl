<?php declare(strict_types=1);

namespace CachedHttpBL\Exception;

use CachedHttpBL\Exception;

/**
 * Exception to be thrown when response was not found in the cache collection.
 */
class ResponseNotExists extends \RuntimeException implements Exception
{
    private $key;

    public function __construct(string $key, int $code = 0, \Exception $previous = null)
    {
        $this->key = $key;

        parent::__construct(
            sprintf('Response for %s IP address was not found in collection', $key),
            $code,
            $previous
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
