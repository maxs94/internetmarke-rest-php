<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Service;

use Maxs94\Internetmarke\Exception\ApiException;
use Maxs94\Internetmarke\Http\ApiClientInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractService
{
    protected ApiClientInterface $apiClient;

    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Decode JSON body into array. Throws ApiException on invalid JSON.
     *
     * @throws ApiException
     *
     * @return array<string,mixed>
     */
    protected function decodeJson(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        if ($body === '') {
            return [];
        }

        $data = json_decode($body, true);
        if (!is_array($data)) {
            throw new ApiException('Invalid JSON response: ' . $body);
        }

        return $data;
    }

    /**
     * Ensure response code is one of the allowed codes; otherwise throw.
     *
     * @param int[] $allowed
     *
     * @throws ApiException
     */
    protected function ensureStatusCode(ResponseInterface $response, array $allowed): void
    {
        $code = $response->getStatusCode();
        if (!in_array($code, $allowed, true)) {
            $body = (string) $response->getBody();
            throw new ApiException(sprintf('Unexpected status code %d: %s', $code, $body), $code);
        }
    }
}
