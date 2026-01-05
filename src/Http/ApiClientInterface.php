<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Http;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

interface ApiClientInterface
{
    /**
     * Perform a GET request.
     *
     * @param array<string,mixed> $options
     *
     * @throws GuzzleException
     */
    public function get(string $uri, mixed $body = null, array $options = []): ResponseInterface;

    /**
     * Perform a POST request.
     *
     * @param array<string,mixed> $options
     *
     * @throws GuzzleException
     */
    public function post(string $uri, mixed $body = null, array $options = []): ResponseInterface;

    /**
     * Perform a PUT request.
     *
     * @param array<string,mixed> $options
     *
     * @throws GuzzleException
     */
    public function put(string $uri, mixed $body = null, array $options = []): ResponseInterface;

    /**
     * Generic request method.
     *
     * @param array<string,mixed> $options
     *
     * @throws GuzzleException
     */
    public function request(string $method, string $uri, mixed $body = null, array $options = []): ResponseInterface;

    /**
     * Returns configured base URI.
     */
    public function getBaseUri(): string;
}
