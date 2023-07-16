<?php declare(strict_types=1);

namespace CachedHttpBL\Functional\Provider;

use CachedHttpBL\Exception\UnexpectedResponseException;
use CachedHttpBL\Provider;
use CachedHttpBL\Provider\ProjectHoneyPotProvider;
use PHPUnit\Framework\TestCase;

class ProjectHoneyPotProviderTest extends TestCase
{
    private Provider $provider;

    protected function setUp(): void
    {
        $this->provider = new ProjectHoneyPotProvider('123457890');
    }

    public function testQueryShouldBeEmpty(): void
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->assertSame('', $this->provider->query('127.0.0.1'));
    }
}
