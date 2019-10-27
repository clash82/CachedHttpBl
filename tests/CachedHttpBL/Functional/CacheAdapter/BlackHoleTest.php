<?php declare(strict_types=1);

namespace CachedHttpBL\Functional\CacheAdapter;

use CachedHttpBL\CacheAdapter\BlackHole;
use PHPUnit\Framework\TestCase;

class BlackHoleTest extends TestCase
{
    /** @var \CachedHttpBL\CacheAdapter */
    private $adapter;

    public function setUp(): void
    {
        $this->adapter = new BlackHole();
    }

    public function testResponseShouldNotExists(): void
    {
        $this->assertEquals(false, $this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsInvalid(): void
    {
        $this->expectException('CachedHttpBL\Exception\ResponseNotExists');
        $this->adapter->getResponse('127.0.0.1');
    }
}
