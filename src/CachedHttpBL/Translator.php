<?php declare(strict_types=1);

namespace CachedHttpBL;

/**
 * Interface for the CachedHttpBL translator.
 */
interface Translator
{
    /**
     * Adds response object.
     */
    public function translate(Response $response): void;

    /**
     * Returns IP short activity description.
     */
    public function getActivityDescription(): string;

    /**
     * Returns IP short threat description.
     */
    public function getThreatDescription(): string;

    /**
     * Returns IP short type meaning description.
     */
    public function getTypeMeaningDescription(): string;
}
