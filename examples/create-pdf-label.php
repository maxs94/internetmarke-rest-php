<?php

declare(strict_types=1);

/**
 * Example: Create a PDF postage label (single stamp, address zone).
 *
 *   INTERNETMARKE_CLIENT_ID=... \
 *   INTERNETMARKE_CLIENT_SECRET=... \
 *   INTERNETMARKE_USERNAME=... \
 *   INTERNETMARKE_PASSWORD=... \
 *   php examples/create-pdf-label.php
 *
 * The stamp PDF will be written to stamp.pdf in the current directory.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Maxs94\Internetmarke\Internetmarke;
use Maxs94\Internetmarke\Model\Address;
use Maxs94\Internetmarke\Model\Position;
use Maxs94\Internetmarke\Model\ShoppingCartPDFRequest;
use Maxs94\Internetmarke\Model\ShoppingCartPosition;

$im = new Internetmarke(
    clientId: (string) getenv('INTERNETMARKE_CLIENT_ID'),
    clientSecret: (string) getenv('INTERNETMARKE_CLIENT_SECRET'),
    username: (string) getenv('INTERNETMARKE_USERNAME'),
    password: (string) getenv('INTERNETMARKE_PASSWORD'),
);

$app = $im->getAppResource();

// Step 1: Open a shopping cart
$cart = $app->createShoppingCart();

// Step 2: Build the stamp position
$sender = (new Address())
    ->setName('Max Mustermann')
    ->setAddressLine1('Musterstraße 1')
    ->setPostalCode('94032')
    ->setCity('Passau')
    ->setCountry('DEU');

$receiver = (new Address())
    ->setName('Erika Mustermann')
    ->setAddressLine1('Beispielgasse 7')
    ->setPostalCode('10115')
    ->setCity('Berlin')
    ->setCountry('DEU');

$position = (new ShoppingCartPosition())
    ->setProductCode(68)  // Kompaktbrief national, adjust as needed
    ->setVoucherLayout(ShoppingCartPosition::VOUCHER_LAYOUT_ADDRESS_ZONE)
    ->setPosition(new Position(1, 1, 1))
    ->setSender($sender)
    ->setReceiver($receiver);

// Step 3: Build and submit the PDF checkout request
$request = (new ShoppingCartPDFRequest())
    ->setShopOrderId($cart->getShopOrderId())
    ->setTotal(95)  // price in cents, must match productCode price
    ->setPositions([$position]);

$result = $app->checkoutShoppingCartAsPDF($request);

// Step 4: Download the label
$pdf = file_get_contents($result->getLink());
file_put_contents('stamp.pdf', $pdf);

echo 'Label saved to stamp.pdf' . PHP_EOL;
echo 'Voucher IDs: ' . implode(', ', array_map(
    fn ($v) => $v->getVoucherId(),
    $result->getShoppingCart()?->getVoucherList() ?? []
)) . PHP_EOL;
