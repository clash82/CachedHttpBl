Cached http:BL PHP class
========================

Version: 1.0.1.0

Author: Rafał Toborek

More about author at [toborek.info](http://toborek.info)

This class will check IPv4 address with http:BL service to determine if it's blacklisted.

See `example.php` for usage example.

Note that error code 1 means that IP address is not listed on http:BL database. It can also mean that your http:BL API key is incorrect. Make sure you have a valid http:BL API key and service is not currently offline.

## Changelog #

1.0.1.0:
- some stupid errors were fixed.

1.0.0.0:
- initial release.