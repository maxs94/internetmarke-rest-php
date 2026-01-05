# ApiVersionResource

### Links

- [API root / Developer docs (German)](https://developer.dhl.com/api-reference/deutsche-post-internetmarke-post-paket-deutschland#operations-tag-ApiVersionResource)

### Overview

- getVersion

### Methods

All methods are called on an instance of `ApiVersionResource`, which can be obtained via the `Internetmarke` facade.

```php
use Maxs94\\Internetmarke\\Internetmarke;

$internetmarke = new Internetmarke(
    'your-client-id',
    'your-client-secret',
    'your-username',
    'your-password'
);

$api = $internetmarke->getApiVersionResource();
$result = $api->getVersion();

echo $result->getVersion();
echo $result->getEnv();
echo $result->getRev();
echo $result->getDescription();
```
