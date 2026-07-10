# Deutsche Post Internetmarke REST Client for PHP

Create and download Internetmarke postage labels directly from PHP using the Deutsche Post REST API.

[![Packagist Version](https://img.shields.io/packagist/v/maxs94/internetmarke-rest-php)](https://packagist.org/packages/maxs94/internetmarke-rest-php)
[![PHP 8.1+](https://img.shields.io/packagist/php-v/maxs94/internetmarke-rest-php)](https://packagist.org/packages/maxs94/internetmarke-rest-php)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Tests](https://github.com/maxs94/internetmarke-rest-php/actions/workflows/tests.yml/badge.svg)](https://github.com/maxs94/internetmarke-rest-php/actions/workflows/tests.yml)
[![PHPStan](https://github.com/maxs94/internetmarke-rest-php/actions/workflows/phpstan.yml/badge.svg)](https://github.com/maxs94/internetmarke-rest-php/actions/workflows/phpstan.yml)

- [DHL Developer Portal](https://developer.dhl.com/api-reference/deutsche-post-internetmarke-post-paket-deutschland)
- [Portokasse](https://portokasse.deutschepost.de/portokasse/)

---

## Install

```bash
composer require maxs94/internetmarke-rest-php
```

---

## Quick example

```php
use Maxs94\Internetmarke\Internetmarke;
use Maxs94\Internetmarke\Model\{Address, Position, ShoppingCartPDFRequest, ShoppingCartPosition};

$im  = new Internetmarke('client-id', 'client-secret', 'username', 'password');
$app = $im->getAppResource();

$cart   = $app->createShoppingCart();
$sender = (new Address())->setName('Max Mustermann')->setAddressLine1('Musterstraße 1')
            ->setPostalCode('94032')->setCity('Passau')->setCountry('DEU');
$receiver = (new Address())->setName('Erika Mustermann')->setAddressLine1('Beispielgasse 7')
            ->setPostalCode('10115')->setCity('Berlin')->setCountry('DEU');

$result = $app->checkoutShoppingCartAsPDF(
    (new ShoppingCartPDFRequest())
        ->setShopOrderId($cart->getShopOrderId())
        ->setTotal(95)  // euro cents
        ->setPositions([
            (new ShoppingCartPosition())
                ->setProductCode(68)  // Kompaktbrief
                ->setVoucherLayout(ShoppingCartPosition::VOUCHER_LAYOUT_ADDRESS_ZONE)
                ->setPosition(new Position(1, 1, 1))
                ->setSender($sender)
                ->setReceiver($receiver),
        ])
);

file_put_contents('stamp.pdf', file_get_contents($result->getLink()));
```

See the [`examples/`](examples/) directory for runnable scripts.

---

## Features

| Feature | This library | Auto-generated SDK | SOAP libs |
|---|:---:|:---:|:---:|
| REST API | ✅ | ✅ | ❌ |
| PHP 8.1+ native | ✅ | ✅ | ✅ |
| Lightweight (1 dep) | ✅ | ❌ | ✅ |
| Typed DTOs | ✅ | ✅ | ✅ |
| Input validation | ✅ | ❌ | ❌ |
| Token auto-refresh | ✅ | ❌ | N/A |
| PDF labels | ✅ | ✅ | ✅ |
| PNG labels | ✅ | ✅ | ✅ |
| Portokasse wallet | ✅ | ✅ | ✅ |
| Retoure (refunds) | ✅ | ✅ | ✅ |

---

## API coverage

| Endpoint | Method | PHP |
|----------|--------|-----|
| `GET /` | Health check | `ApiVersionResource::getVersion()` |
| `POST /user` | Authenticate | handled internally by `TokenProvider` |
| `GET /user/profile` | User profile | `UserResource::getUserProfile()` |
| `PUT /app/wallet` | Charge wallet | `AppResource::chargeWallet(int $amount)` |
| `POST /app/shoppingcart` | Create cart | `AppResource::createShoppingCart()` |
| `GET /app/shoppingcart/{shopOrderId}` | Retrieve cart | `AppResource::getShoppingCart(string $shopOrderId)` |
| `POST /app/shoppingcart/pdf` | Checkout PDF | `AppResource::checkoutShoppingCartAsPDF(...)` |
| `POST /app/shoppingcart/png` | Checkout PNG | `AppResource::checkoutShoppingCartAsPNG(...)` |
| `GET /app/retoure` | Retoure state | `AppResource::getRetoure(...)` |
| `POST /app/retoure` | Request retoure | `AppResource::setRetoure(RetoureVouchersRequest $r)` |
| `GET /app/catalog` | Catalog | `AppResource::getCatalog(array $types)` |

---

## Requirements

- PHP 8.1+
- Composer
- GuzzleHTTP 7+ (pulled in automatically)

---

## Usage

### Authentication

```php
use Maxs94\Internetmarke\Internetmarke;

$im = new Internetmarke(
    clientId:     'your-client-id',
    clientSecret: 'your-client-secret',
    username:     'your-username',
    password:     'your-password',
);

// API version / health check
$version = $im->getApiVersionResource()->getVersion();
echo $version->getVersion(); // e.g. v1.1.4

// User profile
$profile = $im->getUserResource()->getUserProfile();
echo $profile->getFirstname() . ' ' . $profile->getLastname();
```

### Creating a PDF label

```php
use Maxs94\Internetmarke\Model\Address;
use Maxs94\Internetmarke\Model\Position;
use Maxs94\Internetmarke\Model\ShoppingCartPDFRequest;
use Maxs94\Internetmarke\Model\ShoppingCartPosition;

$app = $im->getAppResource();

// 1. Open a cart
$cart = $app->createShoppingCart();

// 2. Build the request
$request = (new ShoppingCartPDFRequest())
    ->setShopOrderId($cart->getShopOrderId())
    ->setTotal(95)  // euro cents — must match position prices
    ->setPositions([
        (new ShoppingCartPosition())
            ->setProductCode(68)
            ->setVoucherLayout(ShoppingCartPosition::VOUCHER_LAYOUT_ADDRESS_ZONE)
            ->setPosition(new Position(1, 1, 1))  // x, y, page
            ->setSender($sender)
            ->setReceiver($receiver),
    ]);

// 3. Checkout
$result = $app->checkoutShoppingCartAsPDF($request);

$pdfLink      = $result->getLink();           // link to the generated PDF
$manifestLink = $result->getManifestLink();   // posting receipt, if requested
$walletLeft   = $result->getWalletBallance(); // remaining balance in euro cents
```

For PNG labels, use `ShoppingCartPNGRequest` and `checkoutShoppingCartAsPNG()`.

Both checkout methods accept optional flags:

```php
$app->checkoutShoppingCartAsPDF($request, validate: true);        // preview — no purchase
$app->checkoutShoppingCartAsPDF($request, directCheckout: true);  // skip cart step
```

### Catalog

```php
use Maxs94\Internetmarke\Model\RetrieveCatalogResponse;

// motif images + product list
$catalog = $app->getCatalog([RetrieveCatalogResponse::TYPE_PUBLIC]);

// page formats (needed for PDF pageFormatId)
$formats = $app->getCatalog([RetrieveCatalogResponse::TYPE_PAGE_FORMATS]);

// both at once
$all = $app->getCatalog([
    RetrieveCatalogResponse::TYPE_PUBLIC,
    RetrieveCatalogResponse::TYPE_PAGE_FORMATS,
]);
```

### Wallet

```php
$app->chargeWallet(500); // charge 5.00 EUR (amount in euro cents, minimum 1)
```

### Retoure

```php
use Maxs94\Internetmarke\Model\RetoureVouchersRequest;
use Maxs94\Internetmarke\Model\ShoppingCart;
use Maxs94\Internetmarke\Model\Voucher;

// query retoure state
$state = $app->getRetoure(
    shopRetoureId:        '12345',
    startDate:            new \DateTimeImmutable('2024-01-01'),
    endDate:              new \DateTimeImmutable('2024-12-31'),
);

// request a refund
$voucher = Voucher::fromArray(['voucherId' => 'A00123C039...']);
$cart    = (new ShoppingCart())->setShopOrderId('98276337')->setVoucherList([$voucher]);

$response = $app->setRetoure((new RetoureVouchersRequest())->setShoppingCart($cart));
echo $response->getShopRetoureId();
```

---

## Validation

All request-side models validate their fields against the OpenAPI spec constraints and throw `\InvalidArgumentException` on violation. Validation is eager — it fires in the setter, at the point of the bad assignment.

| Constraint | Examples |
|------------|---------|
| String length | `Address::setPostalCode` (exactly 5 chars), `Address::setCountry` (exactly 3), `shopOrderId` (1–18) |
| Integer minimum | `chargeWallet $amount` (≥1), `ShoppingCartPosition::productCode` (≥1), `VoucherPosition` coords (≥1) |
| Enum | `ShoppingCartPosition::voucherLayout`, `dpi`, `createShippingList` |
| Array min items | `ShoppingCart::setVoucherList` (≥1 item) |

---

## Sandbox / custom base URI

```php
use Maxs94\Internetmarke\Config\ClientConfig;

$im = new Internetmarke(
    clientId:     'your-client-id',
    clientSecret: 'your-client-secret',
    username:     'your-username',
    password:     'your-password',
    config:       new ClientConfig('https://api-eu.dhl.com/post/de/shipping/im/v1'),
);
```

The default base URI points to production. Pass a `ClientConfig` with a different URL for sandbox testing.

---

## Architecture

```
src/
├── Authentication/   TokenProvider — OAuth token lifecycle
├── Config/           ClientConfig  — base URI
├── Exception/        ApiException
├── Http/             ApiClient, ApiClientInterface, Serializer
├── Model/            DTOs for all request/response payloads
├── Service/          ApiVersionResource, AppResource, UserResource
└── Validator/        StringLengthValidator, IntegerMinValidator, EnumValidator
```

`TokenProvider` and `ApiClient` implement interfaces (`TokenProviderInterface`, `ApiClientInterface`), making them easy to swap in tests or for custom HTTP adapters.

---

## Development

```bash
composer install

make phpunit    # run tests
make phpstan    # static analysis
make csfix      # fix code style
```

---

## Contributing

- Add tests for any new behaviour.
- Run `make phpunit`, `make phpstan`, and `make csfix` before opening a PR.
- Keep backward-compatibility in mind; update docs when making breaking changes.

---

## License

MIT — see [LICENSE](LICENSE).

