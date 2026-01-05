<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class RetoureVouchersResponse
{
    private ?string $shopRetoureId = null;
    private ?string $retoureTransactionId = null;

    public function setShopRetoureId(?string $id): self
    {
        $this->shopRetoureId = $id;

        return $this;
    }

    public function getShopRetoureId(): ?string
    {
        return $this->shopRetoureId;
    }

    public function setRetoureTransactionId(?string $id): self
    {
        $this->retoureTransactionId = $id;

        return $this;
    }

    public function getRetoureTransactionId(): ?string
    {
        return $this->retoureTransactionId;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setShopRetoureId($data['shopRetoureId'] ?? $data['shop_retoure_id'] ?? null);
        $self->setRetoureTransactionId(isset($data['retoureTransactionId']) ? (string) $data['retoureTransactionId'] : ($data['retoure_transaction_id'] ?? null));

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'shopRetoureId' => $this->shopRetoureId,
            'retoureTransactionId' => $this->retoureTransactionId,
        ];
    }
}
