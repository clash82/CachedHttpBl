<?php

// suspicious IP address
$ip = '';

// valid http:BL API key (you can create one at http:BL dashboard)
// please, keep it mind that there's no way to validate this key, so make
// sure you have entered a valid key
$httpbl_api_key = '';

// we are using namespace autoloader
require_once '../vendor/autoload.php';

// setup a new storage adapter
$adapter = new CachedHttpBL\CacheAdapter\CSV(sys_get_temp_dir().'cache.tmp');

// setup library class
$cachedHttpBl = new CachedHttpBL\Client($httpbl_api_key, $adapter);

try {

    // fetch response data from http:BL service
    $response = $cachedHttpBl->checkIP($ip);

    // we'll use an additional translator to output more details about response (useful, but not required)
    $translator = new CachedHttpBL\Translator\ProjectHoneyPot();
    $translator->translate($response);

    echo sprintf('The http:BL service was requested to get details about <b>%s</b> IP address:<br /><br />', $ip);

    echo sprintf('Type code: <strong>%d</strong><br />',
        $response->getType());

    echo sprintf('Activity code: <strong>%d</strong> (<i>%s</i>)<br />',
        $response->getActivity(),
        $translator->getActivityDescription());

    echo sprintf('Threat code: <strong>%d</strong> (<i>%s</i>)<br />',
        $response->getThreat(),
        $translator->getThreatDescription());

    echo sprintf('Type meaning code: <strong>%d</strong> (<i>%s</i>)<br />',
        $response->getTypeMeaning(),
        $translator->getTypeMeaningDescription());

    // write cache for further usage
    $adapter->writeCache();

} catch (\Exception $e) {

    echo sprintf('<br />Houston, we have a problem:<br /><b>%s</b>', $e->getMessage());

}
