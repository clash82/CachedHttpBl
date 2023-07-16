<?php declare(strict_types=1);

namespace CachedHttpBL\Functional\CacheAdapter;

use CachedHttpBL\CacheAdapter;
use CachedHttpBL\CacheAdapter\BlackHoleCacheAdapter;
use CachedHttpBL\Exception\ResponseNotExistsException;
use PHPUnit\Framework\TestCase;

class BlackHoleCacheAdapterTest extends TestCase
{
    private CacheAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new BlackHoleCacheAdapter();
    }

    public function testResponseShouldNotExists(): void
    {
        $this->assertFalse($this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsInvalid(): void
    {
        $this->expectException(ResponseNotExistsException::class);
        $this->adapter->getResponse('127.0.0.1');
    }
}
