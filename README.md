# Internetmarke PHP Client

PHP client for the **Deutsche Post DHL INTERNETMARKE REST API** (spec v1.30).

- [DHL Developer Portal](https://developer.dhl.com/api-reference/deutsche-post-internetmarke-post-paket-deutschland)
- [Portokasse](https://portokasse.deutschepost.de/portokasse/)

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

## Installation

```bash
composer require maxs94/internetmarke-rest-php
```

---

## Quick start

```php
use Maxs94\Internetmarke\Internetmarke;

$im = new Internetmarke(
    clientId:     'your-client-id',
    clientSecret: 'your-client-secret',
    username:     'your-username',
    password:     'your-password',
);

// wallet balance is included in the authentication response
$balance = $im->getTokenProvider()->getAuthentication()->getWalletBalance();

// user profile
$profile = $im->getUserResource()->getUserProfile();
echo $profile->getFirstname() . ' ' . $profile->getLastname();

// API version / health check
$version = $im->getApiVersionResource()->getVersion();
echo $version->getVersion(); // e.g. v1.1.4
```

---

## Creating a label (PDF)

```php
use Maxs94\Internetmarke\Model\Address;
use Maxs94\Internetmarke\Model\Position;
use Maxs94\Internetmarke\Model\ShoppingCartPDFRequest;
use Maxs94\Internetmarke\Model\ShoppingCartPosition;

$app = $im->getAppResource();

// 1. Create a cart and get the shopOrderId
$cart = $app->createShoppingCart();

// 2. Build the checkout request
$request = new ShoppingCartPDFRequest();
$request->setShopOrderId($cart->getShopOrderId());
$request->setTotal(95); // euro cents — must match the sum of your positions

// 3. Build a position (one stamp)
$position = new ShoppingCartPosition();
$position->setProductCode(1);                              // product code from Deutsche Post
$position->setVoucherLayout(ShoppingCartPosition::VOUCHER_LAYOUT_ADDRESS_ZONE);
$position->setPosition(new Position(1, 1, 1));             // x, y, page

$sender = (new Address())
    ->setName('Demo Corp')
    ->setAddressLine1('Somewhere Street 42')
    ->setPostalCode('94032')
    ->setCity('Passau')
    ->setCountry('DEU');

$recipient = (new Address())
    ->setName('Jane Doe')
    ->setAddressLine1('Anywhere Avenue 7')
    ->setPostalCode('10115')
    ->setCity('Berlin')
    ->setCountry('DEU');

$position->setSender($sender);
$position->setReceiver($recipient);
$request->setPositions([$position]);

// 4. Checkout
$result = $app->checkoutShoppingCartAsPDF($request);

$pdfLink      = $result->getLink();           // link to the generated PDF
$manifestLink = $result->getManifestLink();   // posting receipt, if requested
$walletLeft   = $result->getWalletBallance(); // remaining balance in euro cents
```

For PNG labels, replace `ShoppingCartPDFRequest` with `ShoppingCartPNGRequest` and call `checkoutShoppingCartAsPNG()`.

Both checkout methods accept two optional boolean parameters:

```php
$app->checkoutShoppingCartAsPDF($request, validate: true);         // preview — no purchase
$app->checkoutShoppingCartAsPDF($request, directCheckout: true);   // skip separate checkout call
```

---

## Catalog

```php
use Maxs94\Internetmarke\Model\RetrieveCatalogResponse;

// motif images
$catalog = $app->getCatalog([RetrieveCatalogResponse::TYPE_PUBLIC]);

// page formats (needed for PDF pageFormatId)
$formats = $app->getCatalog([RetrieveCatalogResponse::TYPE_PAGE_FORMATS]);

// both at once
$all = $app->getCatalog([
    RetrieveCatalogResponse::TYPE_PUBLIC,
    RetrieveCatalogResponse::TYPE_PAGE_FORMATS,
]);
```

---

## Wallet

```php
$app->chargeWallet(500); // charge 5.00 EUR (amount in euro cents, minimum 1)
```

---

## Retoure

```php
use Maxs94\Internetmarke\Model\RetoureVouchersRequest;
use Maxs94\Internetmarke\Model\ShoppingCart;
use Maxs94\Internetmarke\Model\Voucher;

// query retoure state with optional filters
$state = $app->getRetoure(
    shopRetoureId:          '12345',
    retoureTransactionId:   null,
    startDate:              new \DateTimeImmutable('2024-01-01'),
    endDate:                new \DateTimeImmutable('2024-12-31'),
);

// request a refund
$voucher = Voucher::fromArray(['voucherId' => 'A00123C039...', 'trackId' => '']);
$cart = (new ShoppingCart())->setShopOrderId('98276337')->setVoucherList([$voucher]);

$request = new RetoureVouchersRequest();
$request->setShoppingCart($cart);

$response = $app->setRetoure($request);
echo $response->getShopRetoureId();
echo $response->getRetoureTransactionId();
```

---

## Validation

All request-side models validate their fields against the OpenAPI spec constraints
and throw `\InvalidArgumentException` on violation. Validation is eager — it fires
in the setter, so you get an exception at the point of the bad assignment.

| Constraint | Examples |
|------------|---------|
| String length | `Address::setPostalCode` (exactly 5), `Address::setCountry` (exactly 3), `shopOrderId` (1–18) |
| Integer minimum | `chargeWallet $amount` (≥1), `ShoppingCartPosition::productCode` (≥1), `VoucherPosition` coords (≥1) |
| Enum | `ShoppingCartPosition::voucherLayout`, `dpi`, `createShippingList` |
| Array min items | `ShoppingCart::setVoucherList` (≥1 item) |

---

## Sandbox / custom base URI

```php
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Internetmarke;

$im = new Internetmarke(
    clientId:     'your-client-id',
    clientSecret: 'your-client-secret',
    username:     'your-username',
    password:     'your-password',
    config:       new ClientConfig('https://api-eu.dhl.com/post/de/shipping/im/v1'), // default
);
```

The default base URI points to production. Use `ClientConfig` with a different URL for sandbox or local testing.

---

## Architecture

```
src/
├── Authentication/   TokenProvider — handles OAuth token lifecycle
├── Config/           ClientConfig  — base URI
├── Exception/        ApiException
├── Http/             ApiClient, ApiClientInterface, Serializer
├── Model/            DTOs for all request/response payloads
├── Service/          ApiVersionResource, AppResource, UserResource
└── Validator/        StringLengthValidator, IntegerMinValidator, EnumValidator
```

`TokenProvider` and `ApiClient` both implement interfaces (`TokenProviderInterface`, `ApiClientInterface`), making them straightforward to swap in tests or for custom HTTP adapters.

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
- Run `make phpunit`, `make phpstan`, and `make csfix` before opening a PR — they must pass.
- Keep backward-compatibility in mind; update docs when making breaking changes.

---

## License

MIT — see [LICENSE](LICENSE).

