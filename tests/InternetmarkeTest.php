<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Internetmarke;
use Maxs94\Internetmarke\Service\ApiVersionResource;
use Maxs94\Internetmarke\Service\UserResource;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @internal
 */
final class InternetmarkeTest extends TestCase
{
    public function testProvidesResources(): void
    {
        $guzzle = $this->createMock(GuzzleClientInterface::class);
        $config = new ClientConfig('');
        $logger = $this->createMock(LoggerInterface::class);

        $api = new Internetmarke('cid', 'sec', 'user', 'pass', $logger, $config, $guzzle);

        $this->assertInstanceOf(UserResource::class, $api->getUserResource());
        $this->assertInstanceOf(ApiVersionResource::class, $api->getApiVersionResource());

        // resources should be singletons on the facade
        $this->assertSame($api->getUserResource(), $api->getUserResource());
    }
}
