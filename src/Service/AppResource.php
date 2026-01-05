<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Service;

use Maxs94\Internetmarke\Http\ApiClientInterface;
use Maxs94\Internetmarke\Model\ChargeWalletResponse;
use Maxs94\Internetmarke\Model\RetrieveCatalogResponse;

final class AppResource extends AbstractService
{
    public function __construct(ApiClientInterface $apiClient)
    {
        parent::__construct($apiClient);
    }

    /**
     * PUT /app/wallet?amount=...
     */
    public function chargeWallet(int $amount): ChargeWalletResponse
    {
        $response = $this->apiClient->put('app/wallet', null, ['query' => ['amount' => $amount]]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return ChargeWalletResponse::fromArray($data);
    }

    /**
     * GET /app/catalog?types[]=...
     *
     * @param array<int,string> $types
     */
    public function retrieveCatalogApp(array $types): RetrieveCatalogResponse
    {
        $response = $this->apiClient->get('app/catalog', null, ['query' => ['types' => $types]]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return RetrieveCatalogResponse::fromArray($data);
    }
}
