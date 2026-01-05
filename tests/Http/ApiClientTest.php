<?php

declare(strict_types=1);

namespace Tests\Http;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Maxs94\Internetmarke\Authentication\TokenProvider;
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Http\ApiClient;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Model\AuthenticationResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class ApiClientTest extends TestCase
{
    public function testRequestAddsAuthorizationHeaderAndSerializesBodyAsJson(): void
    {
        $guzzle = $this->createMock(GuzzleClientInterface::class);

        // Create a real TokenProvider instance but seed it with an AuthenticationResponse
        // so it won't try to perform HTTP requests during the test.
        $authRequest = new AuthenticationRequest();
        $clientConfig = new ClientConfig(''); // keep baseUri empty for tests
        $tokenProvider = new TokenProvider($guzzle, $authRequest, $clientConfig);

        $authResponse = AuthenticationResponse::fromArray([
            'access_token' => 'token123',
            'tokenType' => 'Bearer',
            'expires_in' => 3600,
        ]);

        // Use reflection to set private properties on the final TokenProvider instance.
        $ref = new \ReflectionObject($tokenProvider);
        $propAuth = $ref->getProperty('authentication');
        $propAuth->setAccessible(true);
        $propAuth->setValue($tokenProvider, $authResponse);

        $propExpires = $ref->getProperty('expiresAt');
        $propExpires->setAccessible(true);
        $propExpires->setValue($tokenProvider, time() + 3600);

        $guzzle->expects(self::once())
            ->method('request')
            ->with(
                self::equalTo('POST'),
                self::equalTo('/path'),
                self::callback(function (array $options) {
                    // Authorization header should be present (lower-case keys)
                    if (!isset($options['headers']) || !isset($options['headers']['authorization'])) {
                        return false;
                    }
                    if ($options['headers']['authorization'] !== 'Bearer token123') {
                        return false;
                    }

                    // Serializer should have created json key
                    if (!isset($options['json']) || $options['json'] !== ['foo' => 'bar']) {
                        return false;
                    }

                    return true;
                })
            )
            ->willReturn($this->createMock(ResponseInterface::class))
        ;

        $client = new ApiClient($guzzle, $tokenProvider, $clientConfig);

        $client->post('/path', ['foo' => 'bar']);
    }
}
