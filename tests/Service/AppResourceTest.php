<?php

declare(strict_types=1);

namespace Tests;

use Maxs94\Internetmarke\Http\ApiClientInterface;
use Maxs94\Internetmarke\Model\ChargeWalletResponse;
use Maxs94\Internetmarke\Service\AppResource;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class AppResourceTest extends TestCase
{
    public function testChargeWalletReturnsModel(): void
    {
        $apiClient = $this->createMock(ApiClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $response->method('getStatusCode')->willReturn(200);

        $stream = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        $stream->method('__toString')->willReturn('{"shopOrderId":"so-1","walletBalance":250}');
        $response->method('getBody')->willReturn($stream);

        $apiClient->expects($this->once())
            ->method('put')
            ->with('app/wallet', null, ['query' => ['amount' => 150]])
            ->willReturn($response)
        ;

        $app = new AppResource($apiClient);
        $result = $app->chargeWallet(150);

        $this->assertInstanceOf(ChargeWalletResponse::class, $result);
        $this->assertSame('so-1', $result->getShopOrderId());
        $this->assertSame(250, $result->getWalletBalance());
    }
}
