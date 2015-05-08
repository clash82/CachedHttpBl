<?php

namespace CachedHttpBL\Functional\CacheAdapter;

use CachedHttpBL\CacheAdapter\Memory;
use CachedHttpBL\Response\ProjectHoneyPot as ProjectHoneyPotResponse;

class MemoryTest extends \PHPUnit_Framework_TestCase
{
    private $adapter, $response;

    public function setUp() {
        $this->adapter = new Memory();
        $this->response = new ProjectHoneyPotResponse('127.0.0.1', 0, 0, 0, 0, 0);
        $this->adapter->addResponse($this->response);
    }

    public function testResponseShouldExists()
    {
        $this->assertEquals(true, $this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsValid()
    {
        $this->assertEquals($this->response, $this->adapter->getResponse('127.0.0.1'));
    }

    public function testResponseShouldNotExists()
    {
        $this->adapter->clearCache();
        $this->assertEquals(false, $this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsInvalid()
    {
        $this->adapter->clearCache();
        $this->setExpectedException('CachedHttpBL\Exception\ResponseNotExists');
        $this->adapter->getResponse('127.0.0.1');
    }
}
