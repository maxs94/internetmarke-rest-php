<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Authentication;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Maxs94\Internetmarke\Config\ClientConfig;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Model\AuthenticationResponse;
use Psr\Http\Message\ResponseInterface;

final class TokenProvider implements TokenProviderInterface
{
    private ?AuthenticationResponse $authentication = null;
    private ?int $expiresAt = null;
    private string $baseUri;

    /**
     * @param ClientConfig|null $config Optional config containing base URI. If omitted DEFAULT_BASE_URI will be used.
     */
    public function __construct(
        private readonly ClientInterface $guzzle,
        private readonly AuthenticationRequest $authenticationRequest,
        ?ClientConfig $config = null,
    ) {
        $this->baseUri = ($config ?? new ClientConfig())->getBaseUri();
    }

    /**
     * Returns the AuthenticationResponse DTO or null if authentication failed.
     *
     * @throws GuzzleException
     */
    public function getAuthentication(): ?AuthenticationResponse
    {
        if ($this->authentication !== null && $this->expiresAt !== null && time() < $this->expiresAt) {
            return $this->authentication;
        }

        $this->fetchToken();

        return $this->authentication;
    }

    /**
     * Backwards-compatible convenience method that returns only the access token string.
     *
     * @throws GuzzleException
     */
    public function getAccessToken(): ?string
    {
        return $this->getAuthentication()?->getAccessToken();
    }

    /**
     * @throws GuzzleException
     */
    private function fetchToken(): void
    {
        $endpoint = 'user';
        // If endpoint is not absolute, prefix baseUri
        if (!preg_match('#^https?://#i', $endpoint)) {
            $endpoint = rtrim($this->baseUri, '/') . '/' . ltrim($endpoint, '/');
        }

        $formParams = $this->authenticationRequest->toArray();

        // client_id, client_secret, username and password are required
        if (empty($formParams['client_id'])
            || empty($formParams['client_secret'])
            || empty($formParams['username'])
            || empty($formParams['password'])) {
            throw new \InvalidArgumentException('Missing required authentication parameters.');
        }

        $response = $this->guzzle->request('POST', $endpoint, [
            'form_params' => $formParams,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->handleTokenResponse($response);
    }

    private function handleTokenResponse(ResponseInterface $response): void
    {
        $code = $response->getStatusCode();
        $body = (string) $response->getBody();
        $data = json_decode($body, true);

        if ($code !== 200 || !is_array($data) || empty($data['access_token'])) {
            throw new \RuntimeException('Failed to obtain access token: ' . $body);
        }

        $auth = AuthenticationResponse::fromArray($data);
        $this->authentication = $auth;

        $expiresIn = $auth->getExpiresIn() ?? 300;
        $this->expiresAt = (int) (time() + max(30, $expiresIn - 30));
    }
}
