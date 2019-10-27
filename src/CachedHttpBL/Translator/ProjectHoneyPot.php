<?php declare(strict_types=1);

namespace CachedHttpBL\Translator;

use CachedHttpBL\Translator;
use CachedHttpBL\Response;

/**
 * ProjectHoneyPot's response translator.
 *
 * @package CachedHttpBL\Translator
 * @author Rafał Toborek
 */
class ProjectHoneyPot implements Translator
{
    /** @var \CachedHttpBL\Response */
    private $response;

    public function translate(Response $response): void
    {
        $this->response = $response;
    }

    public function getActivityDescription(): string
    {
        return sprintf('last seen %d day(s) ago', $this->response->getActivity());
    }

    public function getThreatDescription(): string
    {
        $threat = $this->response->getThreat();

        if ($threat < 26) {
            return '100 [msg/day]';
        }

        if ($threat > 25 && $threat < 51) {
            return '10,000 [msg/day]';
        }

        return '1,000,000 [msg/day]';
    }

    public function getTypeMeaningDescription(): string
    {
        switch ($this->response->getTypeMeaning()) {
            case 0:
                return 'Search Engine';

            case 1:
                return 'Suspicious';

            case 2:
                return 'Harvester';

            case 4:
                return 'Comment Spammer';

            case 5:
                return 'Suspicious & Comment Spammer';

            case 6:
                return 'Harvester & Comment Spammer';

            case 7:
                return 'Suspicious & Harvester & Comment Spammer';
        }

        return 'Unknown';
    }
}
