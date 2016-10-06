<?php

namespace CachedHttpBL\Response;

use CachedHttpBL\Response;

/**
 * ProjectHoneyPot's response.
 *
 * @package CachedHttpBL\Response
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
    public function __construct($ip, $time, $type, $threat, $typeMeaning, $activity)
    {
        $this->ip = $ip;
        $this->time = $time;
        $this->type = $type;
        $this->threat = $threat;
        $this->typeMeaning = $typeMeaning;
        $this->activity = $activity;
    }

    public function getIP()
    {
        return $this->ip;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getThreat()
    {
        return $this->threat;
    }

    public function getTypeMeaning()
    {
        return $this->typeMeaning;
    }

    public function getActivity()
    {
        return $this->activity;
    }
}
