<?php

declare(strict_types=1);

namespace Tests\Authentication;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Maxs94\Internetmarke\Authentication\TokenProvider;
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Model\AuthenticationResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @internal
 */
final class TokenProviderTest extends TestCase
{
    public function testGetAuthenticationFetchesTokenAndParsesResponse(): void
    {
        $json = json_encode([
            'access_token' => 'abc123',
            'walletBalance' => 500,
            'infoMessage' => 'ok',
            'tokenType' => 'Bearer',
            'expires_in' => 3600,
            'issued_at' => '2026-01-01T12:00:00Z',
        ]);

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $guzzle = $this->createMock(GuzzleClientInterface::class);
        $guzzle->expects(self::once())
            ->method('request')
            ->with(
                self::equalTo('POST'),
                // Accept 'user', '/user' or any absolute URL ending with '/user'
                self::callback(function ($uri) {
                    if (!is_string($uri)) {
                        return false;
                    }
                    if ($uri === 'user' || $uri === '/user') {
                        return true;
                    }

                    return (bool) preg_match('#/user$#', $uri);
                }),
                self::callback(function (array $options) {
                    // form_params should be present and include grant_type
                    if (!isset($options['form_params']) || !isset($options['form_params']['grant_type'])) {
                        return false;
                    }

                    return true;
                })
            )
            ->willReturn($response)
        ;

        $authRequest = new AuthenticationRequest();
        $authRequest->setClientId('cid')->setClientSecret('csecret')->setUsername('user')->setPassword('pass');

        $clientConfig = new ClientConfig(''); // keep baseUri empty for tests
        $provider = new TokenProvider($guzzle, $authRequest, $clientConfig);

        $auth = $provider->getAuthentication();

        $this->assertInstanceOf(AuthenticationResponse::class, $auth);
        $this->assertSame('abc123', $auth->getAccessToken());
        $this->assertSame(500, $auth->getWalletBalance());
    }
}
