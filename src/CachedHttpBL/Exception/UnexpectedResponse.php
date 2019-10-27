<?php declare(strict_types=1);

namespace CachedHttpBL\Exception;

use CachedHttpBL\Exception;

/**
 * Exception to be thrown when unexpected response was returned from the provider.
 */
class UnexpectedResponse extends \RuntimeException implements Exception
{
    private $key;

    public function __construct(string $key, int $code = 0, \Exception $previous = null)
    {
        $this->key = $key;

        parent::__construct(
            sprintf('Unexpected response was returned for %s IP address', $key),
            $code,
            $previous
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
