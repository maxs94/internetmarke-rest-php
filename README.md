# Internetmarke PHP Client

PHP client for the DHL Internetmarke API.

This repository provides:
- HTTP client and service-layer classes to call the Internetmarke API.
- DTO models for request/response payloads.
- Token provider for OAuth-like authentication.
- PHPUnit tests.

Highlights of recent changes
- Base URI for requests is centralized in `ClientConfig`
- `ApiClient` implements `ApiClientInterface`.
- `TokenProvider` implements `TokenProviderInterface`.
- `AuthenticationRequest` DTO introduced and used by `TokenProvider` and `UserResource`.
- Tests were updated to use `ClientConfig('')` to avoid automatic base URI prefixing during unit tests.
- Several classes and tests were adapted to be more testable and type-safe.

Requirements
- PHP 8.1+ (or the project's required PHP version)
- Composer
- Guzzle (provided via composer)
- PHPUnit (dev dependency)

Installation
Use the included Make targets to install dependencies:

```bash
# install PHP dependencies
make install
```

(If you prefer running composer directly, `composer install` is equivalent.)

Usage

1) Centralized configuration
Use `ClientConfig` to configure the API base URI (defaults to the DHL Internetmarke URL). Passing a `ClientConfig` instance to both `TokenProvider` and `ApiClient` ensures a single place to configure the base URI:

```php
use Maxs94\Internetmarke\Config\ClientConfig;

$config = new ClientConfig(); // uses default DHL base URI
// or for staging/custom:
$staging = new ClientConfig('https://staging.example.local/im/v1');
```

2) Obtain a token (TokenProvider)
Create an `AuthenticationRequest` DTO with credentials and construct the `TokenProvider`:

```php
use GuzzleHttp\Client;
use Maxs94\Internetmarke\Authentication\TokenProvider;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Config\ClientConfig;

$guzzle = new Client();
$authRequest = (new AuthenticationRequest())
    ->setClientId('your-client-id')
    ->setClientSecret('your-secret')
    ->setUsername('your-internetmarke-username')
    ->setPassword('your-internetmarke-password')
;

$config = new ClientConfig(); // or custom baseUri
$tokenProvider = new TokenProvider($guzzle, $authRequest, $config);

// get token
$accessToken = $tokenProvider->getAccessToken();
```

3) Create ApiClient and call services
ApiClient requires a `TokenProviderInterface` implementation (the included `TokenProvider` implements it):

```php
use Maxs94\Internetmarke\Http\ApiClient;
use Maxs94\Internetmarke\Config\ClientConfig;

// $guzzle and $tokenProvider from above
$apiClient = new ApiClient($guzzle, $tokenProvider, $config);

// Use service classes (they depend on ApiClientInterface)
$userService = new \Maxs94\Internetmarke\Service\UserResource($apiClient);

// Build AuthenticationRequest DTO and call authorization
$authReq = (new \Maxs94\Internetmarke\Model\AuthenticationRequest())
    ->setClientId('your-client-id')
    ->setClientSecret('your-secret');

$authResponse = $userService->authorization($authReq);
```

Notes on URIs
- If you pass relative URIs to service methods (e.g. `'user'`, `'app/wallet'`), the `ApiClient` will prefix them with the base URI from `ClientConfig`.
- If you pass an absolute URI (starting with `http://` or `https://`), the `ApiClient` will use it unchanged.

Testing
Run the test suite with the Make targets:

```bash
# run unit tests
make test

# or explicitly run phpunit
make phpunit
```

Development notes
- Prefer `ClientConfig` for all places where a base URI must be configured — it centralizes the setting.
- The `ApiClientInterface` and `TokenProviderInterface` allow you to provide your own implementations for special cases (e.g. custom HTTP adapters, testing).
- If you need to mock the token provider or API client in tests, mock the interface types (`TokenProviderInterface` and `ApiClientInterface`) instead of final concrete classes.

Contributing
- Fork the repo, create a branch, add tests for any new behavior, and open a pull request.
- Keep backward-compatibility in mind; update the README and tests when making breaking changes.

License
- Please see the LICENSE file in the repository.

