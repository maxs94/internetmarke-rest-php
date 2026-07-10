<?php

declare(strict_types=1);

/**
 * Example: Authenticate with the Deutsche Post Internetmarke REST API.
 *
 * Set credentials via environment variables before running:
 *
 *   INTERNETMARKE_CLIENT_ID=... \
 *   INTERNETMARKE_CLIENT_SECRET=... \
 *   INTERNETMARKE_USERNAME=... \
 *   INTERNETMARKE_PASSWORD=... \
 *   php examples/authenticate.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Maxs94\Internetmarke\Internetmarke;

$im = new Internetmarke(
    clientId: (string) getenv('INTERNETMARKE_CLIENT_ID'),
    clientSecret: (string) getenv('INTERNETMARKE_CLIENT_SECRET'),
    username: (string) getenv('INTERNETMARKE_USERNAME'),
    password: (string) getenv('INTERNETMARKE_PASSWORD'),
);

// Confirm API connectivity
$version = $im->getApiVersionResource()->getVersion();
echo 'API version: ' . $version->getVersion() . PHP_EOL;

// Confirm authentication with user profile
$profile = $im->getUserResource()->getUserProfile();
echo 'Logged in as: ' . $profile->getFirstname() . ' ' . $profile->getLastname() . PHP_EOL;
echo 'E-Mail: ' . $profile->getMail() . PHP_EOL;
