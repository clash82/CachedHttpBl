<?php declare(strict_types=1);

namespace CachedHttpBL\Translator;

use CachedHttpBL\Response;
use CachedHttpBL\Translator;

/**
 * ProjectHoneyPot's response translator.
 *
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
        $message = 'Unknown';

        switch ($this->response->getTypeMeaning()) {
            case 0:
                $message = 'Search Engine';
                break;

            case 1:
                $message = 'Suspicious';
                break;

            case 2:
                $message = 'Harvester';
                break;

            case 4:
                $message = 'Comment Spammer';
                break;

            case 5:
                $message = 'Suspicious & Comment Spammer';
                break;

            case 6:
                $message = 'Harvester & Comment Spammer';
                break;

            case 7:
                $message = 'Suspicious & Harvester & Comment Spammer';
                break;
        }

        return $message;
    }
}
