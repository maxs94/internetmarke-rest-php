# AppResource

### Links

- [AppResource API Documentation (German)](https://developer.dhl.com/api-reference/deutsche-post-internetmarke-post-paket-deutschland#operations-tag-AppResource)

### Overview

- [chargeWallet](#chargewallet)
- [createShoppingCart](#createshoppingcart)
- [getShoppingCart](#getshoppingcart)
- [checkoutShoppingCartAsPng](#checkoutshoppingcartaspng)
- [checkoutShoppingCartAsPdf](#checkoutshoppingcartaspdf)
- [getCatalog](#getcatalog)
- [getRetoure](#getretoure)
- [setRetoure](#setretoure)

### Methods

All methods are called on an instance of `AppResource`, which can be obtained via the `Internetmarke` facade.

```php
use Maxs94\Internetmarke\Internetmarke;

$internetmarke = new Internetmarke(
    'your-client-id',
    'your-client-secret',
    'your-username',
    'your-password'
);

$appResource = $internetmarke->appResource();
```

#### chargeWallet

```php
 // add 10 cents to wallet
 $appResource->chargeWallet(10);
```

#### createShoppingCart

Creates a new shopping cart and returns a ShoppingCart model.

#### getShoppingCart

Retrieve a shopping cart by shopOrderId.

### checkoutShoppingCartAsPdf / checkoutShoppingCartAsPng

```php
// create shopping cart
$shoppingCart = $appResource->createShoppingCart();

// create checkout request
$request = new ShoppingCartPDFRequest();
$request->setShopOrderId($shoppingCart->getShopOrderId());
$request->setTotal(95); // total amount in cents - needs to match the total of all positions, you will need to calculate this yourself for now

// add cart positions
$cartPosition = new ShoppingCartPosition();
$cartPosition->setImageID(0);
$cartPosition->setProductCode(1); // this is the product code from Deutsche Post (check prodws)
$cartPosition->setVoucherLayout('ADDRESS_ZONE');
$cartPosition->setPosition(new Position(1,1,1));
$request->setPositions([$cartPosition]);

// add sender address
$sender = new Address();
$sender->setName('Demo Corp');
$sender->setAddressLine1('Somewhere Street 42');
$sender->setAddressLine2('Shipping Department');
$sender->setAdditionalName('c/o John Doe');
$sender->setPostalCode('94032');
$sender->setCity('Passau');
$sender->setCountry('DEU');
$cartPosition->setSender($sender);

// add recipient address
$recipient = new Address();
$recipient->setName('Jane Doe');
$recipient->setAddressLine1('Anywhere Avenue 7');
$recipient->setAddressLine2('Apt 13B');
$recipient->setPostalCode('10115');
$recipient->setCity('Berlin');  
$recipient->setCountry('DEU');
$cartPosition->setReceiver($recipient);

$result = $appResource->checkoutShoppingCartAsPdf($request);
var_dump($result);

// get download link to PDF or PNG for the label
$link = $result->getLink();

// manifest
$manifest = $result->getManifest();

// shoppingCart
$shoppingCart = $result->getShoppingCart();

// wallentBalance after Transaction
$walletBalance = $result->getWalletBalance();
```

### getCatalog

```php
// get all available motives and images
$catalog = $appResource->getCatalog(RetrieveCatalogResponse::TYPE_PUBLIC);
var_dump($catalog);

// get all available page formats
$pageFormats = $appResource->getCatalog(RetrieveCatalogResponse::TYPE_PAGE_FORMATS);
var_dump($pageFormats);
```

### getRetoure

```php
$result = $appResource->getRetoure();
var_dump($result);
```

### setRetoure

(implemented, but untested)

