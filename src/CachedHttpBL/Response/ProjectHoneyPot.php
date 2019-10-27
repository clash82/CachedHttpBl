<?php declare(strict_types=1);

namespace CachedHttpBL\Response;

use CachedHttpBL\Response;

/**
 * ProjectHoneyPot's response.
 *
 * @author Rafał Toborek
 */
class ProjectHoneyPot implements Response
{
    /** @var string */
    private $ip;

    /** @var int */
    private $type;

    /** @var int */
    private $threat;

    /** @var int */
    private $typeMeaning;

    /** @var int */
    private $activity;

    /** @var int */
    private $time;

    /**
     * Creates a new ProjectHoneyPot response object.
     *
     * @param string $ip
     * @param int $time
     * @param int $type
     * @param int $threat
     * @param int $typeMeaning
     * @param int $activity
     */
    public function __construct(string $ip, int $time, int $type, int $threat, int $typeMeaning, int $activity)
    {
        $this->ip = $ip;
        $this->time = $time;
        $this->type = $type;
        $this->threat = $threat;
        $this->typeMeaning = $typeMeaning;
        $this->activity = $activity;
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
