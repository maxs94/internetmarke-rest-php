<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Service;

use Maxs94\Internetmarke\Model\ApiVersionResponse;

final class ApiVersionResource extends AbstractService
{
    /**
     * GET /
     */
    public function getVersion(): ApiVersionResponse
    {
        $response = $this->apiClient->get('/');

        $this->log('getVersion response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return ApiVersionResponse::fromArray($data);
    }
}
