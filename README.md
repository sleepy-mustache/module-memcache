# memcache module

* Date:    May 28, 2016
* Author:  Jaime A. Rodriguez <hi.i.am.jaime@gmail.com>
* Version: 2.0
* License: http://opensource.org/licenses/MIT

Memcache module uses a memcache server to cache full pages in memory. This helps
the page load faster, especially when the page is generated using databases or
when using computationally intensive algorithms.

## Changelog

### Version 2.0

Version jumped to 2.0 because there was a fundamental change in how memcache 
works. Previously, it cached on a template bases, but it was buggy in certain
edge cases so we reverted to a full page cache.

## Usage

No user configuration necessary.