<?php declare(strict_types=1);

namespace CachedHttpBL\Functional\Translator;

use CachedHttpBL\Response\ProjectHoneyPotResponse as ProjectHoneyPotResponse;
use CachedHttpBL\Translator\ProjectHoneyPotTranslator as Translator;
use PHPUnit\Framework\TestCase;

class ProjectHoneyPotTranslatorTest extends TestCase
{
    private Translator $translator;

    protected function setUp(): void
    {
        $response = new ProjectHoneyPotResponse('127.0.0.1', 0, 0, 30, 1, 0);
        $this->translator = new Translator();
        $this->translator->translate($response);
    }

    public function testActivityDescriptionShouldNotBeEmpty(): void
    {
        $this->assertSame(\sprintf('last seen %d day(s) ago', 0), $this->translator->getActivityDescription());
    }

    public function testThreatDescriptionShouldNotBeEmpty(): void
    {
        $this->assertSame('10,000 [msg/day]', $this->translator->getThreatDescription());
    }

    public function testTypeMeaningDescriptionShouldNotBeEmpty(): void
    {
        $this->assertSame('Suspicious', $this->translator->getTypeMeaningDescription());
    }
}
