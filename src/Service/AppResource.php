<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Service;

use Maxs94\Internetmarke\Model\ChargeWalletResponse;
use Maxs94\Internetmarke\Model\CheckoutShoppingCartAppResponse;
use Maxs94\Internetmarke\Model\InitShoppingCartResponse;
use Maxs94\Internetmarke\Model\RetoureVouchersRequest;
use Maxs94\Internetmarke\Model\RetoureVouchersResponse;
use Maxs94\Internetmarke\Model\RetrieveCatalogResponse;
use Maxs94\Internetmarke\Model\RetrieveRetoureStateResponse;
use Maxs94\Internetmarke\Model\ShoppingCartPDFRequest;
use Maxs94\Internetmarke\Model\ShoppingCartPNGRequest;
use Maxs94\Internetmarke\Validator\IntegerMinValidator;
use Maxs94\Internetmarke\Validator\StringLengthValidator;

final class AppResource extends AbstractService
{
    /**
     * PUT /app/wallet?amount=...
     */
    public function chargeWallet(int $amount): ChargeWalletResponse
    {
        IntegerMinValidator::validate($amount, 1, 'amount');
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
    public function createShoppingCart(): InitShoppingCartResponse
    {
        $response = $this->apiClient->post('app/shoppingcart');

        $this->log('createShoppingCart response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return InitShoppingCartResponse::fromArray($data);
    }

    /**
     * POST /app/shoppingcart/pdf
     */
    public function checkoutShoppingCartAsPDF(ShoppingCartPDFRequest $request, bool $validate = false, bool $directCheckout = false): CheckoutShoppingCartAppResponse
    {
        $query = array_filter(['validate' => $validate ?: null, 'directCheckout' => $directCheckout ?: null]);
        $response = $this->apiClient->post('app/shoppingcart/pdf', $request, empty($query) ? [] : ['query' => $query]);

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
    public function checkoutShoppingCartAsPNG(ShoppingCartPNGRequest $request, bool $validate = false, bool $directCheckout = false): CheckoutShoppingCartAppResponse
    {
        $query = array_filter(['validate' => $validate ?: null, 'directCheckout' => $directCheckout ?: null]);
        $response = $this->apiClient->post('app/shoppingcart/png', $request, empty($query) ? [] : ['query' => $query]);

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
    public function getShoppingCart(string $shopOrderId): CheckoutShoppingCartAppResponse
    {
        StringLengthValidator::validate($shopOrderId, 1, 18, 'shopOrderId');
        $response = $this->apiClient->get('app/shoppingcart/' . rawurlencode($shopOrderId));

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
    public function getRetoure(
        ?string $shopRetoureId = null,
        ?int $retoureTransactionId = null,
        ?\DateTimeInterface $startDate = null,
        ?\DateTimeInterface $endDate = null,
    ): RetrieveRetoureStateResponse {
        $query = array_filter([
            'shopRetoureId' => $shopRetoureId,
            'retoureTransactionId' => $retoureTransactionId,
            'startDate' => $startDate?->format(\DateTimeInterface::ATOM),
            'endDate' => $endDate?->format(\DateTimeInterface::ATOM),
        ], static fn ($v) => $v !== null);

        $response = $this->apiClient->get('app/retoure', null, empty($query) ? [] : ['query' => $query]);

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
    public function setRetoure(RetoureVouchersRequest $request): RetoureVouchersResponse
    {
        $response = $this->apiClient->post('app/retoure', $request);

        $this->log('setRetoure response', [
            'status' => $response->getStatusCode(),
            'body' => (string) $response->getBody(),
        ]);

        $this->ensureStatusCode($response, [200]);
        $data = $this->decodeJson($response);

        return RetoureVouchersResponse::fromArray($data);
    }

    /**
     * @param string|array<string> $types
     */
    public function getCatalog(string|array $types): RetrieveCatalogResponse
    {
        if (is_string($types)) {
            $types = [$types];
        }

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
