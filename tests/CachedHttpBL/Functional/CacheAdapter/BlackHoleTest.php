<?php

namespace CachedHttpBL\Functional\CacheAdapter;

use CachedHttpBL\CacheAdapter\BlackHole;

class BlackHoleTest extends \PHPUnit_Framework_TestCase
{
    private $adapter;

    public function setUp() {
        $this->adapter = new BlackHole();
    }

    public function testResponseShouldNotExists()
    {
        $this->assertEquals(false, $this->adapter->responseExists('127.0.0.1'));
    }

    public function testResponseIsInvalid()
    {
        $this->setExpectedException('CachedHttpBL\Exception\ResponseNotExists');
        $this->adapter->getResponse('127.0.0.1');
    }
}
