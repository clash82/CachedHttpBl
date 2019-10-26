<?php declare(strict_types=1);

namespace CachedHttpBL\Functional\CacheAdapter;

use CachedHttpBL\CacheAdapter\CSV;
use CachedHttpBL\Response\ProjectHoneyPot as ProjectHoneyPotResponse;
use PHPUnit\Framework\TestCase;

class CVSTest extends TestCase
{
    private $adapter, $response;

    public function setUp(): void {
        $this->adapter = new CSV('/tmp/csv_test.tmp');
        $this->response = new ProjectHoneyPotResponse('127.0.0.1', 0, 0, 0, 0, 0);
        $this->adapter->addResponse($this->response);
    }

    public function testResponseShouldExists(): void
    {
        $this->assertEquals(true, $this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsValid(): void
    {
        $this->assertEquals($this->response, $this->adapter->getResponse('127.0.0.1'));
    }

    public function testResponseShouldNotExists(): void
    {
        $this->adapter->clearCache();
        $this->assertEquals(false, $this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsInvalid(): void
    {
        $this->adapter->clearCache();
        $this->expectException('CachedHttpBL\Exception\ResponseNotExists');
        $this->adapter->getResponse('127.0.0.1');
    }
}
