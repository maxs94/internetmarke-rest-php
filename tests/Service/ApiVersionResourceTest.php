<?php

declare(strict_types=1);

namespace Tests\Service;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Maxs94\Internetmarke\Authentication\TokenProvider;
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Http\ApiClient;
use Maxs94\Internetmarke\Model\ApiVersionResponse;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Model\AuthenticationResponse;
use Maxs94\Internetmarke\Service\ApiVersionResource;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @internal
 */
final class ApiVersionResourceTest extends TestCase
{
    public function testApiVersionReturnsParsedDto(): void
    {
        $payload = json_encode([
            'amp' => [
                'env' => 'production',
                'version' => '1.2.3',
                'description' => 'API v1',
            ],
        ]);

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($payload);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $guzzle = $this->createMock(GuzzleClientInterface::class);
        $guzzle->expects(self::once())
            ->method('request')
            ->with(
                self::equalTo('GET'),
                self::callback(function ($uri) {
                    // Accept root '/' or '' or absolute ending with '/'
                    if (!is_string($uri)) {
                        return false;
                    }
                    if ($uri === '/' || $uri === '') {
                        return true;
                    }

                    return (bool) preg_match('#/$#', $uri) || preg_match('#/v1/?$#', $uri);
                }),
                self::isType('array')
            )
            ->willReturn($response)
        ;

        $clientConfig = new ClientConfig(''); // no prefix for tests

        $authRequest = new AuthenticationRequest();
        $tokenProvider = new TokenProvider($guzzle, $authRequest, $clientConfig);
        $authResponse = AuthenticationResponse::fromArray([
            'access_token' => 'seeded-token',
            'tokenType' => 'Bearer',
            'expires_in' => 3600,
        ]);
        $ref = new \ReflectionObject($tokenProvider);
        $pAuth = $ref->getProperty('authentication');
        $pAuth->setAccessible(true);
        $pAuth->setValue($tokenProvider, $authResponse);
        $pExpires = $ref->getProperty('expiresAt');
        $pExpires->setAccessible(true);
        $pExpires->setValue($tokenProvider, time() + 3600);

        $apiClient = new ApiClient($guzzle, $tokenProvider, $clientConfig);

        $service = new ApiVersionResource($apiClient);

        $dto = $service->getVersion();

        $this->assertInstanceOf(ApiVersionResponse::class, $dto);
        $arr = $dto->toArray();
        $this->assertSame('1.2.3', $arr['version']);
        $this->assertSame('production', $arr['env']);
        $this->assertSame('API v1', $arr['description']);
    }
}
