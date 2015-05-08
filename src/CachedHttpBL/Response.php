<?php

namespace CachedHttpBL;

/**
 * Interface for the CachedHttpBL response object.
 *
 * @package CachedHttpBL
 * @author Rafał Toborek
 */
interface Response
{
    /**
     * @return string
     */
    public function getIP();

    /**
     * @return int
     */
    public function getTime();

    /**
     * @return int
     */
    public function getType();

    /**
     * @return int
     */
    public function getThreat();

    /**
     * @return int
     */
    public function getTypeMeaning();

    /**
     * @return int
     */
    public function getActivity();
}
