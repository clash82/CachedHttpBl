Cached http:BL PHP library
==========================

![phpunit](https://github.com/clash82/CachedHttpBl/actions/workflows/phpunit.yaml/badge.svg)
![phpcs](https://github.com/clash82/CachedHttpBl/actions/workflows/phpcs.yaml/badge.svg)
![php-cs-fixer](https://github.com/clash82/CachedHttpBl/actions/workflows/php-cs-fixer.yaml/badge.svg)
![phpstan](https://github.com/clash82/CachedHttpBl/actions/workflows/phpstan.yaml/badge.svg)
![phpmd](https://github.com/clash82/CachedHttpBl/actions/workflows/phpmd.yaml/badge.svg)
![rector](https://github.com/clash82/CachedHttpBl/actions/workflows/rector.yaml/badge.svg)

Author: [Rafał Toborek](https://kontakt.toborek.info)

Cached http:BL is a PHP (>= v8.3) library that allows you to check an IPv4 address using `Project HoneyPot's http:BL service` to determine whether it is listed on the blacklist.

_Note: If you still need to support PHP 5.x or PHP < 7.2, install version 2.x. For PHP >= 7.2, install version 3.x._

Why use the http:BL service?
----------------------------

Http:BL provides data about the IP addresses of visitors to your website. The data is exchanged via the DNS system. You can query DNS server and receive a response indicating the type of visitor to your site, the level of threat they pose, and how long it has been since they were last seen within the Project Honey Pot trap network.

More details on how the service works can be found on [the official webpage](https://www.projecthoneypot.org/httpbl.php).

Why use the Cached http:BL library?
-----------------------------------

One of the biggest advantages of using the CachedHttpBL library is the ability to cache http:BL responses using cache adapters. You can use one of the available cache adapters (CSV, Memory, BlackHole) or create a new one by implementing a dedicated cache interface. The library is built in an elegant, object-oriented style, allowing you to extend its functionality.

Try it!
-------

Stable version:

```bash
composer require clash82/cachedhttpbl:4.*
```

Here is an example (CLI script) of how to use library with CSV cache adapter:

```php
<?php

// define the suspicious IP address (fill this with the IP address you want to check)
$ip = '';

// provide a valid http:BL API key (you can create one at the http:BL dashboard)
// note: there is no way to validate this key programmatically, so ensure it's correct
$httpblApiKey = '';

// use namespace autoloader
require_once 'CachedHttpBl/vendor/autoload.php';

// create a new storage adapter for caching responses
$adapter = new CachedHttpBL\CacheAdapter\CSVCacheAdapter(sys_get_temp_dir().'/httpbl_cache.csv');

// initialize the provider for Project Honey Pot
$provider = new CachedHttpBL\Provider\ProjectHoneyPotProvider($httpblApiKey);

// set up the CachedHttpBL client
$cachedHttpBl = new CachedHttpBL\Client($provider, $adapter);

try {
    // fetch response data from the http:BL service
    $response = $cachedHttpBl->checkIP($ip);

    // use a translator to provide more detailed information about the response (optional but useful)
    $translator = new CachedHttpBL\Translator\ProjectHoneyPotTranslator();
    $translator->translate($response);

    // output formatted details about the IP address
    printf("The http:BL service was requested to get details about %s IP address:\n\n", $ip);

    printf("Type code: %d\n", $response->getType());
    printf("Activity code: %d (%s)\n", $response->getActivity(), $translator->getActivityDescription());
    printf("Threat code: %d (%s)\n", $response->getThreat(), $translator->getThreatDescription());
    printf("Type meaning code: %d (%s)\n", $response->getTypeMeaning(), $translator->getTypeMeaningDescription());

    // save the cache for future use
    $adapter->writeCache();
} catch (\Exception $e) {
    // handle errors gracefully
    printf("Error: Unable to retrieve details for the given IP address. %s\n", $e->getMessage());
}
```

Launch the Test Suite
---------------------

In the CachedHttpBL directory:

```bash
composer test
```

Change log
----------

[v4.2.0](https://github.com/clash82/CachedHttpBl/releases/tag/v4.2.0):
- added support for PHP v8.4, v8.5 thanks to [matteotrubini](https://github.com/matteotrubini).

[v4.1.0](https://github.com/clash82/CachedHttpBl/releases/tag/v4.1.0):
- dropped support for PHP < v8.3.

[v4.0.0](https://github.com/clash82/CachedHttpBl/releases/tag/v4.0.0):
- dropped support for PHP < v8.1 (use v3.x instead),
- Travis-CI integration was replaced with GitHub Actions,
- added logical operator `is` for `Translator` class type meanings (eg. `isHarversterType()`, `isUnknownType()`, etc.),
- code refactor and upgrades.

[v3.0.0](https://github.com/clash82/CachedHttpBl/releases/tag/v3.0.0):
- dropped support for PHP v5.x and PHP < v7.2 (use v2.x instead),
- added full support for PHP v7.2 and PHP v7.3 (enabled strict_types),
- enabled Travis-CI integration for phpstan, php-cs-fixer, phpmd and phpcs,
- fixed minor issues and adjusted coding standards.

[v2.0.0](https://github.com/clash82/CachedHttpBl/releases/tag/v2.0.0):
- added PSR-2 coding standards,
- added lot of improvements and bug fixes,
- completely refactored code (added more abstract class model, interfaces, cache adapters etc.),
- added tests.

[v1.0.1](https://github.com/clash82/CachedHttpBl/releases/tag/v1.0.1.0):
- some stupid errors were fixed.

v1.0.0:
- initial release.

Jezus żyje! 🧡
