<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Service;

use Maxs94\Internetmarke\Model\ChargeWalletResponse;
use Maxs94\Internetmarke\Model\CheckoutShoppingCartAppResponse;
use Maxs94\Internetmarke\Model\RetoureVouchersRequest;
use Maxs94\Internetmarke\Model\RetrieveCatalogResponse;
use Maxs94\Internetmarke\Model\RetrieveRetoureStateResponse;
use Maxs94\Internetmarke\Model\ShoppingCart;
use Maxs94\Internetmarke\Model\ShoppingCartPDFRequest;
use Maxs94\Internetmarke\Model\ShoppingCartPNGRequest;

final class AppResource extends AbstractService
{
    /**
     * PUT /app/wallet?amount=...
     */
    public function chargeWallet(int $amount): ChargeWalletResponse
    {
        $response = $this->apiClient->put('app/wallet', null, ['query' => ['amount' => $amount]]);

        $this->log('chargeWallet response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return ChargeWalletResponse::fromArray($data);
    }

    /**
     * POST /app/shoppingcart
     */
    public function createShoppingCart(): ShoppingCart
    {
        $response = $this->apiClient->post('app/shoppingcart');

        $this->log('createShoppingCart response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return ShoppingCart::fromArray($data);
    }

    /**
     * POST /app/shoppingcart/pdf
     */
    public function checkoutShoppingCartAsPDF(ShoppingCartPDFRequest $request): CheckoutShoppingCartAppResponse
    {
        $response = $this->apiClient->post('app/shoppingcart/pdf', $request);

        $this->log('checkoutShoppingCartAsPDF response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return CheckoutShoppingCartAppResponse::fromArray($data);
    }

    /**
     * POST /app/shoppingcart/png
     */
    public function checkoutShoppingCartAsPNG(ShoppingCartPNGRequest $request): CheckoutShoppingCartAppResponse
    {
        $response = $this->apiClient->post('app/shoppingcart/png', $request);

        $this->log('checkoutShoppingCartAsPNG response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return CheckoutShoppingCartAppResponse::fromArray($data);
    }

    /**
     * GET /app/shoppingcart/{shopOrderId}
     */
    public function getShoppingCart(int $shopOrderId): CheckoutShoppingCartAppResponse
    {
        $response = $this->apiClient->get('app/shoppingcart/' . rawurlencode((string) $shopOrderId));

        $this->log('getShoppingCart response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return CheckoutShoppingCartAppResponse::fromArray($data);
    }

    /**
     * GET /app/retoure
     */
    public function getRetoure(): RetrieveRetoureStateResponse
    {
        $response = $this->apiClient->get('app/retoure');

        $this->log('getRetoure response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return RetrieveRetoureStateResponse::fromArray($data);
    }

    /**
     * POST /app/retoure
     */
    public function setRetoure(RetoureVouchersRequest $request): RetrieveRetoureStateResponse
    {
        $response = $this->apiClient->post('app/retoure', $request);

        $this->log('setRetoure response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return RetrieveRetoureStateResponse::fromArray($data);
    }

    /**
     * GET /app/catalog?types=...
     */
    public function getCatalog(string $types): RetrieveCatalogResponse
    {
        $response = $this->apiClient->get('app/catalog', null, ['query' => ['types' => $types]]);

        $this->log('getCatalog response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return RetrieveCatalogResponse::fromArray($data);
    }
}
