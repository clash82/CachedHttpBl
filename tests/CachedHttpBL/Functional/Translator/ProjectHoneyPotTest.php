<?php declare(strict_types=1);

namespace CachedHttpBL\Functional\CacheAdapter;

use CachedHttpBL\Response\ProjectHoneyPot as ProjectHoneyPotResponse;
use CachedHttpBL\Translator\ProjectHoneyPot as Translator;
use PHPUnit\Framework\TestCase;

class ProjectHoneyPotTest extends TestCase
{
    private $translator;

    public function setUp(): void
    {
        $response = new ProjectHoneyPotResponse('127.0.0.1', 0, 0, 30, 1, 0);
        $this->translator = new Translator();
        $this->translator->translate($response);
    }

    public function testActivityDescriptionShouldNotBeEmpty(): void
    {
        $this->assertEquals(sprintf('last seen %d day(s) ago', 0), $this->translator->getActivityDescription());
    }

    public function testThreatDescriptionShouldNotBeEmpty(): void
    {
        $this->assertEquals('10,000 [msg/day]', $this->translator->getThreatDescription());
    }

    public function testTypeMeaningDescriptionShouldNotBeEmpty(): void
    {
        $this->assertEquals('Suspicious', $this->translator->getTypeMeaningDescription());
    }
}
