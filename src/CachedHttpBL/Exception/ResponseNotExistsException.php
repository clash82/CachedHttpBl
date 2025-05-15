<?php declare(strict_types=1);

namespace CachedHttpBL\Exception;

use CachedHttpBL\Exception;

/**
 * Exception to be thrown when response was not found in the cache collection.
 */
class ResponseNotExistsException extends \RuntimeException implements Exception
{
    public function __construct(private readonly string $key, int $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            \sprintf('Response for %s IP address was not found in collection', $key),
            $code,
            $previous
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
