<?php declare(strict_types=1);

namespace CachedHttpBL\Functional\Provider;

use CachedHttpBL\Provider\ProjectHoneyPot;
use PHPUnit\Framework\TestCase;

class ProjectHoneyPotTest extends TestCase
{
    private $provider;

    public function setUp(): void
    {
        $this->provider = new ProjectHoneyPot('123457890');
    }

    public function testQueryShouldBeEmpty(): void
    {
        $this->expectException('CachedHttpBL\Exception\UnexpectedResponse');
        $this->assertEquals('', $this->provider->query('127.0.0.1'));
    }
}
