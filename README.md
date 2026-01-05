# Internetmarke PHP Client

## PHP client for the Deutsche Post DHL Internetmarke API.

### Links 

- [Internetmarke API Documentation (German)](https://www.dhl.de/de/geschaeftskunden/internetmarke/api.html)
- [DHL Developer Portal (German)](https://entwickler.dhl.de/)
- [Portokasse](https://portokasse.deutschepost.de/portokasse/)

### This repository provides:

- HTTP client and service-layer classes to call the Internetmarke API.
- DTO models for request/response payloads.
- Token provider for OAuth-like authentication.
- PHPUnit tests.

### Highlights of recent changes

- Base URI for requests is centralized in `ClientConfig`
- `ApiClient` implements `ApiClientInterface`.
- `TokenProvider` implements `TokenProviderInterface`.
- `AuthenticationRequest` DTO introduced and used by `TokenProvider` and `UserResource`.
- Tests were updated to use `ClientConfig('')` to avoid automatic base URI prefixing during unit tests.
- Several classes and tests were adapted to be more testable and type-safe.
- added Makefile for common tasks (install, test, etc.)
- added Internetmarke facade for easy setup and usage.

### Requirements

- PHP 8.1+ (or the project's required PHP version)
- Composer
- client (provided via composer)
- PHPUnit (dev dependency)

### Installation

Use the included Make targets to install dependencies:

```bash
# install PHP dependencies
make install
```

(If you prefer running composer directly, `composer install` is equivalent.)

### Usage

The simplest way to get started is to use the `Internetmarke` facade class, which handles configuration, token provision, and API client setup for you:

```php
use Maxs94\Internetmarke\Internetmarke;

$internetmarke = Internetmarke::create([
    'client_id' => 'your-client-id',
    'client_secret' => 'your-secret',
    'username' => 'your-internetmarke-username',
    'password' => 'your-internetmarke-password',
]);

// walletBalance can be retrieved from the tokenProvider,
// as DHL includes it in the authentication response
var_dump($internetmarke->getTokenProvider()->getAuthentication()->getWalletBalance());

// get user profile
var_dump($internetmarke->getUserResource()->getUserProfile());
```


### Testing

Run the test suite with the Make targets:

```bash
# or explicitly run phpunit
make phpunit

# run static analysis
make phpstan

# fix coding standards issues
make csfix
```

### Development notes

- Prefer `ClientConfig` for all places where a base URI must be configured — it centralizes the setting.
- The `ApiClientInterface` and `TokenProviderInterface` allow you to provide your own implementations for special cases (e.g. custom HTTP adapters, testing).
- If you need to mock the token provider or API client in tests, mock the interface types (`TokenProviderInterface` and `ApiClientInterface`) instead of final concrete classes.

### Contributing

- Fork the repo, create a branch, add tests for any new behavior and open a pull request.
- Keep backward-compatibility in mind; update the README and tests when making breaking changes.
- Run `make phpunit`, `make csfix` and `make phpstan` before submitting a PR - they should pass without errors.
 
### License

- Please see the LICENSE file in the repository.

