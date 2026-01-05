<?php

declare(strict_types=1);

namespace Tests\Service;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Maxs94\Internetmarke\Authentication\TokenProvider;
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Http\ApiClient;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Model\AuthenticationResponse;
use Maxs94\Internetmarke\Model\ChargeWalletResponse;
use Maxs94\Internetmarke\Model\RetrieveCatalogResponse;
use Maxs94\Internetmarke\Service\AppResource;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @internal
 */
final class AppResourceTest extends TestCase
{
    public function testChargeWalletSendsPutWithQueryAndReturnsDto(): void
    {
        $payload = json_encode([
            'shopOrderId' => 'order-xyz',
            'walletBalance' => 150,
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
                self::equalTo('PUT'),
                self::callback(function ($uri) {
                    return is_string($uri) && preg_match('#app/wallet$#', $uri);
                }),
                self::callback(function ($opts) {
                    return is_array($opts) && isset($opts['query'], $opts['query']['amount']) && $opts['query']['amount'] === 100;
                })
            )
            ->willReturn($response)
        ;

        $clientConfig = new ClientConfig(''); // keep baseUri empty for tests

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

        $service = new AppResource($apiClient);

        $dto = $service->chargeWallet(100);

        $this->assertInstanceOf(ChargeWalletResponse::class, $dto);
        $arr = $dto->toArray();
        $this->assertSame('order-xyz', $arr['shopOrderId']);
        $this->assertSame(150, $arr['walletBalance']);
    }

    public function testRetrieveCatalogAppSendsTypesQueryAndParsesResponse(): void
    {
        $payload = json_encode([
            'pageFormats' => [
                [
                    'id' => 1,
                    'name' => 'A4',
                    'isAddressPossible' => true,
                    'isImagePossible' => true,
                ],
            ],
            'contractProducts' => [
                'products' => [
                    ['productCode' => 123, 'price' => 50],
                ],
            ],
        ]);

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($payload);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $types = ['PUBLIC', 'PAGE_FORMATS'];

        $guzzle = $this->createMock(GuzzleClientInterface::class);
        $guzzle->expects(self::once())
            ->method('request')
            ->with(
                self::equalTo('GET'),
                self::callback(function ($uri) {
                    return is_string($uri) && preg_match('#app/catalog$#', $uri);
                }),
                self::callback(function ($opts) use ($types) {
                    return is_array($opts) && isset($opts['query'], $opts['query']['types']) && $opts['query']['types'] === $types;
                })
            )
            ->willReturn($response)
        ;

        $clientConfig = new ClientConfig(''); // keep baseUri empty for tests

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

        $service = new AppResource($apiClient);

        $dto = $service->retrieveCatalogApp($types);

        $this->assertInstanceOf(RetrieveCatalogResponse::class, $dto);
        $arr = $dto->toArray();

        $this->assertArrayHasKey('pageFormats', $arr);
        $this->assertCount(1, $arr['pageFormats']);
        $this->assertSame(1, $arr['pageFormats'][0]['id']);

        $this->assertArrayHasKey('contractProducts', $arr);
        $this->assertArrayHasKey('products', $arr['contractProducts']);
        $this->assertCount(1, $arr['contractProducts']['products']);
        $this->assertSame(123, $arr['contractProducts']['products'][0]['productCode']);
    }
}
