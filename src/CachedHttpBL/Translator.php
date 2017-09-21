<?php

namespace CachedHttpBL;

/**
 * Interface for the CachedHttpBL translator.
 *
 * @package CachedHttpBL
 * @author Rafał Toborek
 */
interface Translator
{
    /**
     * Adds response object.
     *
     * @param Response $response
     */
    public function translate(Response $response);

    /**
     * Returns IP short activity description.
     *
     * @return string
     */
    public function getActivityDescription();

    /**
     * Returns IP short threat description.
     *
     * @return string
     */
    public function getThreatDescription();

    /**
     * Returns IP short type meaning description.
     *
     * @return string
     */
    public function getTypeMeaningDescription();
}
