<?php

namespace CachedHttpBL\Functional\CacheAdapter;

use CachedHttpBL\Translator\ProjectHoneyPot as Translator;
use CachedHttpBL\Response\ProjectHoneyPot as ProjectHoneyPotResponse;
use CachedHttpBL\CacheAdapter\Memory;

class ProjectHoneyPotTest extends \PHPUnit_Framework_TestCase
{
    private $translator;

    public function setUp() {
        $response = new ProjectHoneyPotResponse('127.0.0.1', 0, 0, 30, 1, 0);
        $this->translator = new Translator();
        $this->translator->translate($response);
    }

    public function testActivityDescriptionShouldNotBeEmpty()
    {
        $this->assertEquals(sprintf('last seen %d day(s) ago', 0), $this->translator->getActivityDescription());
    }

    public function testThreatDescriptionShouldNotBeEmpty()
    {
        $this->assertEquals('10,000 [msg/day]', $this->translator->getThreatDescription());
    }

    public function testTypeMeaningDescriptionShouldNotBeEmpty()
    {
        $this->assertEquals('Suspicious', $this->translator->getTypeMeaningDescription());
    }
}
