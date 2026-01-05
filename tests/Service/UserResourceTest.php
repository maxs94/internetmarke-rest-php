<?php

declare(strict_types=1);

namespace Tests\Service;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Maxs94\Internetmarke\Authentication\TokenProvider;
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Http\ApiClient;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Model\AuthenticationResponse;
use Maxs94\Internetmarke\Service\UserResource;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @internal
 */
final class UserResourceTest extends TestCase
{
    public function testAuthorizationSendsRequestAndReturnsAuthenticationResponse(): void
    {
        $json = json_encode([
            'access_token' => 'tk',
            'tokenType' => 'Bearer',
            'expires_in' => 120,
        ]);

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($json);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);
        $response->method('getBody')->willReturn($stream);

        $guzzle = $this->createMock(GuzzleClientInterface::class);

        // Expect Guzzle request called by ApiClient
        $guzzle->expects(self::once())
            ->method('request')
            ->with(
                self::equalTo('POST'),
                // Accept 'user' or '/user' or absolute ending with '/user'
                self::callback(function ($uri) {
                    if (!is_string($uri)) {
                        return false;
                    }
                    if ($uri === 'user' || $uri === '/user') {
                        return true;
                    }

                    return (bool) preg_match('#/user$#', $uri);
                }),
                self::callback(function ($options) {
                    // content-type header and form_params should be present
                    if (!is_array($options)) {
                        return false;
                    }
                    if (!isset($options['headers']) || !isset($options['headers']['content-type'])) {
                        return false;
                    }
                    if (!isset($options['form_params'])) {
                        return false;
                    }

                    return true;
                })
            )
            ->willReturn($response)
        ;

        $clientConfig = new ClientConfig(''); // keep baseUri empty for expectations

        // Create and seed TokenProvider so it returns an access token without network call
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

        $service = new UserResource($apiClient);

        $req = new AuthenticationRequest();
        $req->setClientId('cid')->setClientSecret('sec');

        $auth = $service->authorization($req);

        $this->assertInstanceOf(AuthenticationResponse::class, $auth);
        $this->assertSame('tk', $auth->getAccessToken());
    }
}
