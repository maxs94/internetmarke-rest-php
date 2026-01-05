<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Service;

use GuzzleHttp\Exception\GuzzleException;
use Maxs94\Internetmarke\Exception\ApiException;
use Maxs94\Internetmarke\Model\AuthenticationRequest;
use Maxs94\Internetmarke\Model\AuthenticationResponse;
use Maxs94\Internetmarke\Model\RetrieveUserDataResponse;

final class UserResource extends AbstractService
{
    /**
     * POST /user
     *
     * Accepts an AuthenticationRequest DTO and sends it as form params
     * (application/x-www-form-urlencoded).
     *
     * @param array<string,mixed> $options additional guzzle options (headers, etc.)
     *
     * @throws GuzzleException
     * @throws ApiException
     */
    public function authorization(AuthenticationRequest $request, array $options = []): AuthenticationResponse
    {
        $headers = $options['headers'] ?? [];
        $headers = array_change_key_case((array) $headers, CASE_LOWER);

        if (!isset($headers['content-type'])) {
            $headers['content-type'] = 'application/x-www-form-urlencoded';
        }

        $options['headers'] = $headers;

        $response = $this->apiClient->post('user', $request, $options);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return AuthenticationResponse::fromArray($data);
    }

    /**
     * GET /user/profile
     *
     * @throws GuzzleException
     * @throws ApiException
     */
    public function retrieveUserData(): RetrieveUserDataResponse
    {
        $response = $this->apiClient->get('user/profile');

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return RetrieveUserDataResponse::fromArray($data);
    }
}
