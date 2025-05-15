<?php declare(strict_types=1);

namespace CachedHttpBL\Exception;

use CachedHttpBL\Exception;

/**
 * Exception to be thrown when cache is not writable.
 */
class CacheNotWritableException extends \RuntimeException implements Exception
{
    public function __construct(private readonly string $key, int $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            \sprintf('There was an error while trying write to `%s`', $key),
            $code,
            $previous
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
