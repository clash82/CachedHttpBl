Cached http:BL PHP library
==========================

![phpunit](https://github.com/clash82/CachedHttpBl/actions/workflows/phpunit.yaml/badge.svg)
![phpcs](https://github.com/clash82/CachedHttpBl/actions/workflows/phpcs.yaml/badge.svg)
![php-cs-fixer](https://github.com/clash82/CachedHttpBl/actions/workflows/php-cs-fixer.yaml/badge.svg)
![phpstan](https://github.com/clash82/CachedHttpBl/actions/workflows/phpstan.yaml/badge.svg)
![phpmd](https://github.com/clash82/CachedHttpBl/actions/workflows/phpmd.yaml/badge.svg)
![rector](https://github.com/clash82/CachedHttpBl/actions/workflows/rector.yaml/badge.svg)

Author: [Rafał Toborek](https://kontakt.toborek.info)

Cached http:BL is a PHP >=v8.3 library which allows you to check IPv4 address with `Project HoneyPot's http:BL service` to determine if it's located on the blacklist.

_Note: If you still need to support PHP 5.x or PHP <7.2 then install version 2.x. For PHP >=7.2 install version 3.x._

Why use http:BL service?
------------------------

Http:BL provides data back about the IP addresses of visitors to your website. Data is exchanged over the DNS system. You may query your local DNS server and receive a response back that indicates the type of visitor to your site, how threatening that visitor is, and how long it has been since the visitor has last been seen within the Project Honey Pot trap network.

More details on how service works can be found on [an official webpage](https://www.projecthoneypot.org/httpbl.php).

Why use Cached http:BL library?
-------------------------------

One of the biggest advantages of using CachedHttpBL library is a possibility to cache http:BL responses by using cache adapters. You can use one of the available cache adapters (CSV, Memory, BlackHole) or create a new one by implementing dedicated cache interface. Library is built in an elegant objective style allowing you to extend it's functionality.

Try it!
-------

Stable version:

```bash
$ composer require clash82/cachedhttpbl:4.*
```

Here is an example (CLI script) of how to use library with CSV cache adapter:

```php
<?php

// suspicious IP address (fill this with the IP address you want to check)
$ip = '';

// valid http:BL API key (you can create one at http:BL dashboard)
// keep it mind that there's no way to validate this key, so make
// sure you have entered a valid key
$httpblApiKey = '';

// we are using namespace autoloader
require_once 'CachedHttpBl/vendor/autoload.php';

// create a new storage adapter
$adapter = new CachedHttpBL\CacheAdapter\CSVCacheAdapter(sys_get_temp_dir().'/httpbl_cache.csv');

// create a new provider
$provider = new CachedHttpBL\Provider\ProjectHoneyPotProvider($httpblApiKey);

// setup library class
$cachedHttpBl = new CachedHttpBL\Client($provider, $adapter);

try {
    // fetch response data from http:BL service
    $response = $cachedHttpBl->checkIP($ip);

    // additional translator to output more details about the Response (useful, but not required)
    $translator = new CachedHttpBL\Translator\ProjectHoneyPotTranslator();
    $translator->translate($response);

    printf('The http:BL service was requested to get details about %s IP address:'.\PHP_EOL.\PHP_EOL, $ip);

    printf(
        'Type code: %d'.\PHP_EOL,
        $response->getType()
    );

    printf(
        'Activity code: %d (%s)'.\PHP_EOL,
        $response->getActivity(),
        $translator->getActivityDescription()
    );

    printf(
        'Threat code: %d (%s)'.\PHP_EOL,
        $response->getThreat(),
        $translator->getThreatDescription()
    );

    printf(
        'Type meaning code: %d (%s)'.\PHP_EOL,
        $response->getTypeMeaning(),
        $translator->getTypeMeaningDescription()
    );

    // write cache for further usage
    $adapter->writeCache();
} catch (\Exception $e) {
    printf('Something went wrong or no details about the given IP address were found: %s', $e->getMessage());
}
```

Launch the Test Suite
---------------------

In the CachedHttpBL directory:

```bash
$ vendor/bin/phpunit
```

Change log
----------

[v4.1.0](https://github.com/clash82/CachedHttpBl/releases/tag/v4.1.0):
- dropped support for PHP <8.3.

[v4.0.0](https://github.com/clash82/CachedHttpBl/releases/tag/v4.0.0):
- dropped support for PHP <8.1 (use v3.x instead),
- Travis-CI integration was replaced with GitHub Actions,
- added logical operator `is` for `Translator` class type meanings (eg. `isHarversterType()`, `isUnknownType()`, etc.),
- code refactor and upgrades.

[v3.0.0](https://github.com/clash82/CachedHttpBl/releases/tag/v3.0.0):
- dropped support for PHP 5.x and PHP <7.2 (use v2.x instead),
- added full support for PHP 7.2 and PHP 7.3 (enabled strict_types),
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
