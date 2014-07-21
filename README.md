AppNexus Read-Only API
======================

[![Latest Stable Version](https://poser.pugx.org/swco/appnexusapi/v/stable.svg)](https://packagist.org/packages/swco/appnexusapi) [![Build Status](https://travis-ci.org/swco/appnexusapi.svg?branch=master)](https://travis-ci.org/swco/appnexusapi) [![License](https://poser.pugx.org/swco/appnexusapi/license.svg)](https://packagist.org/packages/swco/appnexusapi)

Installation
------------

This library requires PHP 5.3 or later, and is installable and autoloadable via Composer as [swco/appnexusapi](https://packagist.org/packages/swco/appnexusapi).

Getting Started
---------------

The examples below show a few different ways you can access data.

When accessing data through the helper `get*` methods the request is sent straight away and returns an array of objects.

When using the `get($service, $reset = true)` method you can continue to apply filtering before calling `send()`. With `send()` you also get the `Response` object returned rather than a regular array. This gives access to a few more methods like `getStatus()` and `getStartElement()`.

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
echo $brands->getStatus();// OK

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

Advanced
--------

Some services (currently Brand) have their own special filter, this is accompanied with a Request wrapper;

```php
use \SWCO\AppNexusAPI\Request;
use \SWCO\AppNexusAPI\BrandRequest;

$request = new Request("username", "password");

$brand = BrandRequest::newFromRequest($request);

$brand->simple();

...
```

This allows for extra functionality such as access to the `simple()` method above that removes the `num_creatives` data
making the API call a lot faster.

You can also send the simple flags through the helper functions `getBrand()` and `getBrands()`;

```php
use \SWCO\AppNexusAPI\Request;
use \SWCO\AppNexusAPI\BrandRequest;

$request = new Request("username", "password");

$brand = BrandRequest::newFromRequest($request);

$simple = true;
$brand->getBrand(1, $simple);
```

Auth
----

For heavier usage it is worth storing the token for re-use. The token doesn't change and the library handles re-authing when needed.

Auth can be handled via the request object or using the `Auth` object directly;

```php
use \SWCO\AppNexusAPI\Request;

$request = new Request("username", "password");
$token = $request->auth();

// Store $token somewhere
```

```php
use \SWCO\AppNexusAPI\Auth;
use \Guzzle\Http\Client;
use \SWCO\AppNexusAPI\Request;
use \SWCO\AppNexusAPI\Exceptions\NoAuthException;

$auth = new Auth();
$auth->setClient(new Client(Request::APP_NEXUS_API_URL));
try {
    $token = $auth->auth('username', 'password');
} catch (NoAuthException $e) {
    $token = null;
}

if ($token) {
    // Store $token somewhere
}
```
