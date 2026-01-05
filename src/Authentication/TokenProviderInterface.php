<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Authentication;

use GuzzleHttp\Exception\GuzzleException;
use Maxs94\Internetmarke\Model\AuthenticationResponse;

interface TokenProviderInterface
{
    /**
     * Returns the AuthenticationResponse DTO or null if authentication failed.
     *
     * @throws GuzzleException
     */
    public function getAuthentication(): ?AuthenticationResponse;

    /**
     * Returns the access token string or null.
     *
     * @throws GuzzleException
     */
    public function getAccessToken(): ?string;
}
