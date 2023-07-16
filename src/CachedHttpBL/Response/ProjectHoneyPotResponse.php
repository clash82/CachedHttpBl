<?php declare(strict_types=1);

namespace CachedHttpBL\Response;

use CachedHttpBL\Response;

/**
 * ProjectHoneyPot's response.
 */
class ProjectHoneyPotResponse implements Response
{
    /**
     * Creates a new ProjectHoneyPot response object.
     */
    public function __construct(
        private readonly string $ip,
        private readonly int $time,
        private readonly int $type,
        private readonly int $threat,
        private readonly int $typeMeaning,
        private readonly int $activity
    ) {
    }

    public function getIP(): string
    {
        return $this->ip;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getThreat(): int
    {
        return $this->threat;
    }

    public function getTypeMeaning(): int
    {
        return $this->typeMeaning;
    }

    public function getActivity(): int
    {
        return $this->activity;
    }
}
