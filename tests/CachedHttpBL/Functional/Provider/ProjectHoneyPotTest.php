<?php

namespace CachedHttpBL\Functional\Provider;

use CachedHttpBL\Provider\ProjectHoneyPot;

class ProjectHoneyPotTest extends \PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp() {
        $this->provider = new ProjectHoneyPot('123457890');
    }

    public function testQueryShouldBeEmpty()
    {
        $this->setExpectedException('CachedHttpBL\Exception\UnexpectedResponse');
        $this->assertEquals('', $this->provider->query('127.0.0.1'));
    }
}
