<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class InitShoppingCartResponse
{
    private ?string $shopOrderId = null;

    public function setShopOrderId(?string $id): self
    {
        $this->shopOrderId = $id;

        return $this;
    }

    public function getShopOrderId(): ?string
    {
        return $this->shopOrderId;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setShopOrderId($data['shopOrderId'] ?? $data['shop_order_id'] ?? null);

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'shopOrderId' => $this->shopOrderId,
        ];
    }
}
