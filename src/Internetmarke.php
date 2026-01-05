<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Maxs94\Internetmarke\Authentication\TokenProvider;
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Http\ApiClient;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Service\ApiVersionResource;
use Maxs94\Internetmarke\Service\AppResource;
use Maxs94\Internetmarke\Service\UserResource;

final class Internetmarke
{
    private ClientConfig $config;
    private ClientInterface $guzzle;
    private TokenProvider $tokenProvider;
    private ApiClient $apiClient;

    private ?UserResource $userResource = null;
    private ?ApiVersionResource $apiVersionResource = null;
    private ?AppResource $appResource = null;

    public function __construct(string $clientId, string $clientSecret, string $username, string $password, ?ClientConfig $config = null, ?ClientInterface $guzzle = null)
    {
        $this->config = $config ?? new ClientConfig();
        $this->guzzle = $guzzle ?? new Client(['base_uri' => $this->config->getBaseUri()]);

        $auth = new AuthenticationRequest();
        $auth->setClientId($clientId)->setClientSecret($clientSecret);
        $auth->setUsername($username);
        $auth->setPassword($password);

        $this->tokenProvider = new TokenProvider($this->guzzle, $auth, $this->config);
        $this->apiClient = new ApiClient($this->guzzle, $this->tokenProvider, $this->config);
    }

    public function getTokenProvider(): TokenProvider
    {
        return $this->tokenProvider;
    }

    public function getUserResource(): UserResource
    {
        if ($this->userResource === null) {
            $this->userResource = new UserResource($this->apiClient);
        }

        return $this->userResource;
    }

    public function getApiVersionResource(): ApiVersionResource
    {
        if ($this->apiVersionResource === null) {
            $this->apiVersionResource = new ApiVersionResource($this->apiClient);
        }

        return $this->apiVersionResource;
    }

    public function getAppResource(): AppResource
    {
        if ($this->appResource === null) {
            $this->appResource = new AppResource($this->apiClient);
        }

        return $this->appResource;
    }
}
