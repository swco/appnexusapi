AppNexus Read-Only API
======================

```php
use \SWCO\AppNexusAPI\Request;

$request = new Request("username", "password");

// Get category ID 1 and 7
$categories = $request->whereId(array(1, 7))->getCategories();

// Get category ID 5
$category = $request->setCategory(5);

// Get all brands update since June 2014
$brands = $request->get(Request::SERVICE_BRAND)->since(new DateTime('June 2014'))->send();

// Domain Audit Statuses are a bit different as they needs some post data
$domainAuditStatus = $request->getDomainAuditStatuses(array('google.com'));
```
