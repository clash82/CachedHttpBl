<?php declare(strict_types=1);

namespace CachedHttpBL\Exception;

use CachedHttpBL\Exception;

/**
 * Exception to be thrown when unexpected response was returned from the provider.
 */
class UnexpectedResponseException extends \RuntimeException implements Exception
{
    public function __construct(private readonly string $key, int $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            \sprintf('Unexpected response was returned for %s IP address', $key),
            $code,
            $previous
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
