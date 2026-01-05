<?php

declare(strict_types=1);

namespace Maxs94\Internetmarke\Model;

final class ChargeWalletResponse
{
    private ?string $shopOrderId = null;
    private ?int $walletBalance = null;

    public function setShopOrderId(?string $id): self
    {
        $this->shopOrderId = $id;

        return $this;
    }

    public function getShopOrderId(): ?string
    {
        return $this->shopOrderId;
    }

    public function setWalletBalance(?int $balance): self
    {
        $this->walletBalance = $balance;

        return $this;
    }

    public function getWalletBalance(): ?int
    {
        return $this->walletBalance;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->setShopOrderId($data['shopOrderId'] ?? $data['shop_order_id'] ?? null);
        $self->setWalletBalance(isset($data['walletBalance']) ? (int) $data['walletBalance'] : (isset($data['wallet_balance']) ? (int) $data['wallet_balance'] : null));

        return $self;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'shopOrderId' => $this->shopOrderId,
            'walletBalance' => $this->walletBalance,
        ];
    }
}
