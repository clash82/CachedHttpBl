Cached http:BL PHP library
==========================

![phpunit](https://github.com/clash82/CachedHttpBl/actions/workflows/phpunit.yaml/badge.svg)
![phpcs](https://github.com/clash82/CachedHttpBl/actions/workflows/phpcs.yaml/badge.svg)
![php-cs-fixer](https://github.com/clash82/CachedHttpBl/actions/workflows/php-cs-fixer.yaml/badge.svg)
![phpstan](https://github.com/clash82/CachedHttpBl/actions/workflows/phpstan.yaml/badge.svg)
![phpmd](https://github.com/clash82/CachedHttpBl/actions/workflows/phpmd.yaml/badge.svg)

[![Code Climate](https://codeclimate.com/github/clash82/CachedHttpBl/badges/gpa.svg)](https://codeclimate.com/github/clash82/CachedHttpBl)
[![Issue Count](https://codeclimate.com/github/clash82/CachedHttpBl/badges/issue_count.svg)](https://codeclimate.com/github/clash82/CachedHttpBl)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clash82/CachedHttpBl/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/clash82/CachedHttpBl/?branch=master)

Author: [Rafał Toborek](https://kontakt.toborek.info)

Cached http:BL is a PHP >=7.2 library which allows you to check IPv4 address with `Project HoneyPot's http:BL service` to determine if it's located on the blacklist.

_Note: If you still need to support PHP 5 or PHP <7.2 version then please install version 2.x. of this library._

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
$ php composer.phar require clash82/cachedhttpbl:3.*
```

Here is an example of how to use library with CSV cache adapter:

```php
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
```

Launch the Test Suite
---------------------

In the CachedHttpBL directory:

```bash
$ phpunit
```

Change log
----------

[v3.0.0](https://github.com/clash82/CachedHttpBl/releases/tag/v3.0.0):
- dropped support for PHP 5.x and PHP <7.2 (please use v2.x instead),
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
