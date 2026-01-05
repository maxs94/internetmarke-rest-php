<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Maxs94\Internetmarke\Authentication\TokenProvider;
use Maxs94\Internetmarke\Authentication\TokenProviderInterface;
use Maxs94\Internetmarke\Config\ClientConfig;
use Psr\Http\Message\ResponseInterface;

final class ApiClient implements ApiClientInterface
{
    private ClientInterface $guzzle;
    private TokenProviderInterface $tokenProvider;
    private string $baseUri;

    /**
     * @param ClientConfig|null $config Optional config containing base URI. If omitted DEFAULT_BASE_URI will be used.
     */
    public function __construct(ClientInterface $guzzle, TokenProvider $tokenProvider, ?ClientConfig $config = null)
    {
        $this->guzzle = $guzzle;
        $this->tokenProvider = $tokenProvider;
        $this->baseUri = ($config ?? new ClientConfig())->getBaseUri();
    }

    public function get(string $uri, mixed $body = null, array $options = []): ResponseInterface
    {
        return $this->request('GET', $uri, $body, $options);
    }

    public function post(string $uri, mixed $body = null, array $options = []): ResponseInterface
    {
        return $this->request('POST', $uri, $body, $options);
    }

    public function put(string $uri, mixed $body = null, array $options = []): ResponseInterface
    {
        return $this->request('PUT', $uri, $body, $options);
    }

    /**
     * Generic request method that ensures Authorization header and serializes DTOs automatically.
     *
     * @param string $uri Relative or absolute URI. If relative, will be prefixed with baseUri.
     * @param mixed $body DTO/array/string
     * @param array<string,mixed> $options
     *
     * @throws GuzzleException
     */
    public function request(string $method, string $uri, mixed $body = null, array $options = []): ResponseInterface
    {
        $token = $this->tokenProvider->getAccessToken();

        // normalize header keys to lower-case
        $headers = array_change_key_case((array) ($options['headers'] ?? []), CASE_LOWER);

        if ($token !== null) {
            $headers['authorization'] = 'Bearer ' . $token;
        }

        $options['headers'] = $headers;

        if ($body !== null) {
            $serialized = Serializer::toRequestOptions($body, $headers);
            $options = array_merge($options, $serialized);
        }

        // If $uri is not absolute, prefix with configured base URI.
        if (!preg_match('#^https?://#i', $uri)) {
            $uri = rtrim($this->baseUri, '/') . '/' . ltrim($uri, '/');
        }

        return $this->guzzle->request($method, $uri, $options);
    }

    /**
     * Returns the configured base URI (useful for tests or consumers).
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
}
