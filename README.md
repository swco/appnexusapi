AppNexus Read-Only API
======================

[![Latest Stable Version](https://poser.pugx.org/swco/appnexusapi/v/stable.svg)](https://packagist.org/packages/swco/appnexusapi) [![Build Status](https://travis-ci.org/swco/appnexusapi.svg?branch=master)](https://travis-ci.org/swco/appnexusapi) [![License](https://poser.pugx.org/swco/appnexusapi/license.svg)](https://packagist.org/packages/swco/appnexusapi)

The examples below show a few different ways you can access data. When accessing data through the helper `get*` methods the request is sent straight away. When using the `get($service, $reset = true)` method you can continue to apply filtering before calling `send()`.

The second param passed to `get()` allows you to reset all the filters (default action). Passing `false` will stop `reset()` being called.

```php
use \SWCO\AppNexusAPI\Request;

$request = new Request("username", "password");

// Get category ID 1 and 7
$categories = $request->whereId(array(1, 7))->getCategories();

// Get category ID 5
$category = $request->getCategory(5);

// Get all brands update since June 2014
$brands = $request->get(Request::SERVICE_BRAND)->since(new DateTime('June 2014'))->send();

// Domain Audit Statuses are a bit different as they needs some post data
$domainAuditStatus = $request->getDomainAuditStatuses(array('google.com'));
```

All services' parameters default to their falsey value;

```
string = '';
int = 0;
bool = false;
array = array();
float = 0.0;
```

The only exception to this rule is params that should be an object, if unset these will return null;

```
object = null;
```
