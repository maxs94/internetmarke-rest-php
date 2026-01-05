<?php

declare(strict_types=1);

namespace Tests;

use Maxs94\Internetmarke\Http\ApiClientInterface;
use Maxs94\Internetmarke\Model\RetrieveUserDataResponse;
use Maxs94\Internetmarke\Service\UserResource;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class UserResourceTest extends TestCase
{
    public function testGetUserProfileReturnsModel(): void
    {
        $apiClient = $this->createMock(ApiClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $response->method('getStatusCode')->willReturn(200);
        $stream = $this->createMock(\Psr\Http\Message\StreamInterface::class);
        $stream->method('__toString')->willReturn('{"ekp":"123","firstname":"John","lastname":"Doe"}');
        $response->method('getBody')->willReturn($stream);

        $apiClient->expects($this->once())
            ->method('get')
            ->with('user/profile')
            ->willReturn($response)
        ;

        $userResource = new UserResource($apiClient);
        $result = $userResource->getUserProfile();

        $this->assertInstanceOf(RetrieveUserDataResponse::class, $result);
        $this->assertSame('123', $result->getEkp());
        $this->assertSame('John', $result->getFirstname());
        $this->assertSame('Doe', $result->getLastname());
    }
}
