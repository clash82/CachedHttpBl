<?php declare(strict_types=1);

namespace CachedHttpBL\Translator;

use CachedHttpBL\Response;
use CachedHttpBL\Translator;

/**
 * ProjectHoneyPot's response translator.
 */
class ProjectHoneyPotTranslator implements Translator
{
    private const array TYPE_MEANING_DESCRIPTION = [
        0 => 'Search Engine',
        1 => 'Suspicious',
        2 => 'Harvester',
        4 => 'Comment Spammer',
        5 => 'Suspicious & Comment Spammer',
        6 => 'Harvester & Comment Spammer',
        7 => 'Suspicious & Harvester & Comment Spammer',
    ];

    private Response $response;

    public function translate(Response $response): void
    {
        $this->response = $response;
    }

    public function getActivityDescription(): string
    {
        return \sprintf('last seen %d day(s) ago', $this->response->getActivity());
    }

    public function getThreatDescription(): string
    {
        $threat = $this->response->getThreat();

        $message = '1,000,000 [msg/day]';

        if ($threat < 26) {
            $message = '100 [msg/day]';
        }

        if ($threat < 51) {
            $message = '10,000 [msg/day]';
        }

        return $message;
    }

    public function getTypeMeaningDescription(): string
    {
        return self::TYPE_MEANING_DESCRIPTION[$this->response->getTypeMeaning()] ?? 'Unknown';
    }

    public function isUnknownType(): bool
    {
        return !isset(self::TYPE_MEANING_DESCRIPTION[$this->response->getTypeMeaning()]);
    }

    public function isSearchEngineType(): bool
    {
        return $this->response->getTypeMeaning() === 0;
    }

    public function isSuspiciousType(): bool
    {
        return $this->response->getTypeMeaning() === 1;
    }

    public function isHarvesterType(): bool
    {
        return $this->response->getTypeMeaning() === 2;
    }

    public function isCommentSpammerType(): bool
    {
        return $this->response->getTypeMeaning() === 4;
    }

    public function isSuspiciousAndCommentSpammerType(): bool
    {
        return $this->response->getTypeMeaning() === 5;
    }

    public function isHarvesterAndCommentSpammerType(): bool
    {
        return $this->response->getTypeMeaning() === 6;
    }

    public function isSuspiciousAndHarvesterAndCommentSpammerType(): bool
    {
        return $this->response->getTypeMeaning() === 7;
    }
}
