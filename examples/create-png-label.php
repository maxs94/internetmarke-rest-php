<?php

declare(strict_types=1);

/**
 * Example: Create a PNG postage label (franking zone, no address printed).
 *
 *   INTERNETMARKE_CLIENT_ID=... \
 *   INTERNETMARKE_CLIENT_SECRET=... \
 *   INTERNETMARKE_USERNAME=... \
 *   INTERNETMARKE_PASSWORD=... \
 *   php examples/create-png-label.php
 *
 * Individual PNG images will be saved to the current directory.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Maxs94\Internetmarke\Internetmarke;
use Maxs94\Internetmarke\Model\ShoppingCartPNGRequest;
use Maxs94\Internetmarke\Model\ShoppingCartPosition;

$im = new Internetmarke(
    clientId: (string) getenv('INTERNETMARKE_CLIENT_ID'),
    clientSecret: (string) getenv('INTERNETMARKE_CLIENT_SECRET'),
    username: (string) getenv('INTERNETMARKE_USERNAME'),
    password: (string) getenv('INTERNETMARKE_PASSWORD'),
);

$app = $im->getAppResource();

$cart = $app->createShoppingCart();

// Franking zone: no sender/receiver printed — just the stamp graphic
$position = (new ShoppingCartPosition())
    ->setProductCode(68)
    ->setVoucherLayout(ShoppingCartPosition::VOUCHER_LAYOUT_FRANKING_ZONE);

$request = (new ShoppingCartPNGRequest())
    ->setShopOrderId($cart->getShopOrderId())
    ->setTotal(95)
    ->setDpi(ShoppingCartPNGRequest::DPI300)
    ->setPositions([$position]);

$result = $app->checkoutShoppingCartAsPNG($request);

// The link contains a ZIP file with all individual PNG stamps
$zip = file_get_contents($result->getLink());
file_put_contents('stamps.zip', $zip);

echo 'Stamps saved to stamps.zip' . PHP_EOL;

// Voucher IDs and tracking IDs
foreach ($result->getShoppingCart()?->getVoucherList() ?? [] as $voucher) {
    echo 'Voucher: ' . $voucher->getVoucherId() . PHP_EOL;
}
