# UserResource

### Links

- [UserResource API Documentation (German)](https://developer.dhl.com/api-reference/deutsche-post-internetmarke-post-paket-deutschland#operations-tag-UserResource)

### Overview

- getUserProfile

### Methods

All methods are called on an instance of `UserResource`, which can be obtained via the `Internetmarke` facade.

```php
use Maxs94\\Internetmarke\\Internetmarke;

$internetmarke = new Internetmarke(
    'your-client-id',
    'your-client-secret',
    'your-username',
    'your-password'
);

$user = $internetmarke->getUserResource();
$profile = $user->getUserProfile();

var_dump($profile->toArray());
echo $profile->getFirstname();
echo $profile->getLastname();
```
