<?php declare(strict_types=1);

namespace CachedHttpBL\Exception;

use CachedHttpBL\Exception;

/**
 * Exception to be thrown when cache is not writable.
 */
class CacheNotWritable extends \RuntimeException implements Exception
{
    /** @var string */
    private $key;

    public function __construct(string $key, int $code = 0, \Exception $previous = null)
    {
        $this->key = $key;

        parent::__construct(
            sprintf('There was an error while trying write to `%s`', $key),
            $code,
            $previous
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
