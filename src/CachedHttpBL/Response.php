<?php declare(strict_types=1);

namespace CachedHttpBL;

/**
 * Interface for the CachedHttpBL response object.
 */
interface Response
{
    public function getIP(): string;

    public function getTime(): int;

    public function getType(): int;

    public function getThreat(): int;

    public function getTypeMeaning(): int;

    public function getActivity(): int;
}
