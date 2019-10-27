<?php declare(strict_types=1);

namespace CachedHttpBL;

/**
 * Interface for the CachedHttpBL response object.
 *
 * @author Rafał Toborek
 */
interface Response
{
    /**
     * @return string
     */
    public function getIP(): string;

    /**
     * @return int
     */
    public function getTime(): int;

    /**
     * @return int
     */
    public function getType(): int;

    /**
     * @return int
     */
    public function getThreat(): int;

    /**
     * @return int
     */
    public function getTypeMeaning(): int;

    /**
     * @return int
     */
    public function getActivity(): int;
}
