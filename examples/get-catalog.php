<?php

declare(strict_types=1);

/**
 * Example: Retrieve the product catalogue.
 *
 *   INTERNETMARKE_CLIENT_ID=... \
 *   INTERNETMARKE_CLIENT_SECRET=... \
 *   INTERNETMARKE_USERNAME=... \
 *   INTERNETMARKE_PASSWORD=... \
 *   php examples/get-catalog.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Maxs94\Internetmarke\Internetmarke;
use Maxs94\Internetmarke\Model\RetrieveCatalogResponse;

$im = new Internetmarke(
    clientId: (string) getenv('INTERNETMARKE_CLIENT_ID'),
    clientSecret: (string) getenv('INTERNETMARKE_CLIENT_SECRET'),
    username: (string) getenv('INTERNETMARKE_USERNAME'),
    password: (string) getenv('INTERNETMARKE_PASSWORD'),
);

$app = $im->getAppResource();

$catalog = $app->getCatalog([RetrieveCatalogResponse::TYPE_PUBLIC]);

// Contract products (product code + price)
$contractProducts = $catalog->getContractProducts();
if ($contractProducts !== null) {
    echo "Contract products:\n";
    foreach ($contractProducts->getProducts() as $product) {
        printf("  Product %-6d  %s EUR\n",
            $product->getProductCode(),
            number_format((int) $product->getPrice() / 100, 2, '.', '')
        );
    }
}

// Public catalog items (categories with stamp images)
$publicCatalog = $catalog->getPublicCatalog();
if ($publicCatalog !== null) {
    echo "\nPublic catalog categories:\n";
    foreach ($publicCatalog->getItems() as $item) {
        printf("  [%d] %s\n", $item->getCategoryId(), $item->getCategoryDescription());
    }
}

// Available page formats for PDF layouts
echo "\nPage formats:\n";
foreach ($catalog->getPageFormats() as $format) {
    printf("  ID %-4d  %s\n", $format->getId(), $format->getName());
}
