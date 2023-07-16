<?php declare(strict_types=1);

namespace CachedHttpBL\Functional\CacheAdapter;

use CachedHttpBL\CacheAdapter;
use CachedHttpBL\CacheAdapter\CSVCacheAdapter;
use CachedHttpBL\Exception\ResponseNotExistsException;
use CachedHttpBL\Response;
use CachedHttpBL\Response\ProjectHoneyPotResponse as ProjectHoneyPotResponse;
use PHPUnit\Framework\TestCase;

class CSVCacheAdapterTest extends TestCase
{
    private CacheAdapter $adapter;

    private Response $response;

    protected function setUp(): void
    {
        $this->adapter = new CSVCacheAdapter('/tmp/csv_test.tmp');
        $this->response = new ProjectHoneyPotResponse('127.0.0.1', 0, 0, 0, 0, 0);
        $this->adapter->addResponse($this->response);
    }

    public function testResponseShouldExists(): void
    {
        $this->assertTrue($this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsValid(): void
    {
        $this->assertSame($this->response, $this->adapter->getResponse('127.0.0.1'));
    }

    public function testResponseShouldNotExists(): void
    {
        $this->adapter->clearCache();
        $this->assertFalse($this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsInvalid(): void
    {
        $this->adapter->clearCache();
        $this->expectException(ResponseNotExistsException::class);
        $this->adapter->getResponse('127.0.0.1');
    }
}
