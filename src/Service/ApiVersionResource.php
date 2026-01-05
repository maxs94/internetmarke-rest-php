<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Service;

use Maxs94\Internetmarke\Http\ApiClientInterface;
use Maxs94\Internetmarke\Model\ApiVersionResponse;

final class ApiVersionResource extends AbstractService
{
    public function __construct(ApiClientInterface $apiClient)
    {
        parent::__construct($apiClient);
    }

    /**
     * GET /
     */
    public function apiVersion(): ApiVersionResponse
    {
        $response = $this->apiClient->get('/');

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return ApiVersionResponse::fromArray($data);
    }
}
