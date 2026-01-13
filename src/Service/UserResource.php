<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Service;

use GuzzleHttp\Exception\GuzzleException;
use Maxs94\Internetmarke\Exception\ApiException;
use Maxs94\Internetmarke\Model\RetrieveUserDataResponse;

final class UserResource extends AbstractService
{
    /**
     * GET /user/profile
     *
     * @throws GuzzleException
     * @throws ApiException
     */
    public function getUserProfile(): RetrieveUserDataResponse
    {
        $response = $this->apiClient->get('user/profile');

        $this->log('getUserProfile response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return RetrieveUserDataResponse::fromArray($data);
    }
}
