<?php declare(strict_types=1);

namespace CachedHttpBL;

/**
 * Interface for the CachedHttpBL translator.
 *
 * @author Rafał Toborek
 */
interface Translator
{
    /**
     * Adds response object.
     *
     * @param Response $response
     */
    public function translate(Response $response): void;

    /**
     * Returns IP short activity description.
     *
     * @return string
     */
    public function getActivityDescription(): string;

    /**
     * Returns IP short threat description.
     *
     * @return string
     */
    public function getThreatDescription(): string;

    /**
     * Returns IP short type meaning description.
     *
     * @return string
     */
    public function getTypeMeaningDescription(): string;
}
